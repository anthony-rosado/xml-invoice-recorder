<?php

namespace Tests\Feature\Http\Controllers\Invoices;

use App\Models\Acquirer;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Issuer;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DeleteInvoiceControllerTest extends TestCase
{
    public function testDeleteInvoice(): void
    {
        $transactionType = TransactionType::query()
            ->inRandomOrder()
            ->first();
        $documentType = DocumentType::query()
            ->inRandomOrder()
            ->first();
        $currency = Currency::query()
            ->inRandomOrder()
            ->first();
        $issuer = Issuer::factory()->createOne();
        $acquirer = Acquirer::factory()->createOne();
        $user = User::factory()->createOne();
        $items = InvoiceItem::factory()->count(3);
        $invoice = Invoice::factory()
            ->for($transactionType)
            ->for($documentType)
            ->for($currency)
            ->for($issuer)
            ->for($acquirer)
            ->for($user)
            ->has($items, 'items')
            ->createOne();

        $invoiceItems = $invoice->items()->get();

        Passport::actingAs($user);

        $response = $this->deleteJson('/api/invoices/' . $invoice->getKey());

        $response->assertNoContent();

        $this->assertDatabaseMissing('invoices', ['id' => $invoice->getKey()]);
        $this->assertDatabaseMissing('invoice_tax', ['invoice_id' => $invoice->getKey()]);

        foreach ($invoiceItems as $item) {
            $this->assertDatabaseMissing(
                'invoice_items',
                ['code' => $item->code, 'invoice_id' => $invoice->getKey()]
            );
            $this->assertDatabaseMissing('invoice_item_tax', ['item_id' => $item->getKey()]);
        }
    }

    public function testCannotDeleteInvoiceNotFound(): void
    {
        $invoiceId = 9999;
        $user = User::factory()->createOne();

        Passport::actingAs($user);

        $response = $this->deleteJson('/api/invoices/' . $invoiceId);

        $response->assertNotFound();

        $this->assertDatabaseMissing('invoices', ['id' => $invoiceId]);
    }

    public function testCannotDeleteInvoiceWithoutAuthentication(): void
    {
        $transactionType = TransactionType::query()
            ->inRandomOrder()
            ->first();
        $documentType = DocumentType::query()
            ->inRandomOrder()
            ->first();
        $currency = Currency::query()
            ->inRandomOrder()
            ->first();
        $issuer = Issuer::factory()->createOne();
        $acquirer = Acquirer::factory()->createOne();
        $user = User::factory()->createOne();
        $items = InvoiceItem::factory()->count(3);
        $invoice = Invoice::factory()
            ->for($transactionType)
            ->for($documentType)
            ->for($currency)
            ->for($issuer)
            ->for($acquirer)
            ->for($user)
            ->has($items, 'items')
            ->createOne();

        $response = $this->deleteJson('/api/invoices/' . $invoice->getKey());

        self::assertNotTrue($this->isAuthenticated());

        $response->assertUnauthorized()
            ->assertJson(
                fn (AssertableJson $json) => $json->has('message')
                    ->whereType('message', 'string')
            );
    }
}
