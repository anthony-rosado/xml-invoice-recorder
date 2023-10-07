<?php

namespace Tests\Feature\Services;

use App\Enums\TaxCode;
use App\Models\Acquirer;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Issuer;
use App\Models\Tax;
use App\Models\TransactionType;
use App\Models\User;
use App\Services\InvoiceItemService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class InvoiceItemServiceTest extends TestCase
{
    use WithFaker;

    public function testCreateInvoiceItem(): void
    {
        $transactionType = TransactionType::query()->inRandomOrder()->first();
        $documentType = DocumentType::query()->inRandomOrder()->first();
        $currency = Currency::query()->inRandomOrder()->first();
        $issuer = Issuer::factory()->createOne();
        $acquirer = Acquirer::factory()->createOne();
        $user = User::factory()->createOne();
        $invoice = Invoice::factory()
            ->for($transactionType)
            ->for($documentType)
            ->for($currency)
            ->for($issuer)
            ->for($acquirer)
            ->for($user)
            ->createOne();
        $invoiceItem = InvoiceItem::factory()->makeOne();

        $service = app(InvoiceItemService::class);
        $service->create($invoiceItem->attributesToArray(), $invoice);

        $this->assertDatabaseHas(
            'invoice_items',
            [
                'code' => $invoiceItem->code,
                'invoice_id' => $invoice->getKey(),
            ]
        );
    }

    public function testAddTaxesToInvoiceItem(): void
    {
        $transactionType = TransactionType::query()->inRandomOrder()->first();
        $documentType = DocumentType::query()->inRandomOrder()->first();
        $currency = Currency::query()->inRandomOrder()->first();
        $issuer = Issuer::factory()->createOne();
        $acquirer = Acquirer::factory()->createOne();
        $user = User::factory()->createOne();
        $invoice = Invoice::factory()
            ->for($transactionType)
            ->for($documentType)
            ->for($currency)
            ->for($issuer)
            ->for($acquirer)
            ->for($user)
            ->createOne();
        $invoiceItem = InvoiceItem::factory()
            ->for($invoice)
            ->createOne();

        $itemTaxes = [
            ['code' => TaxCode::Igv->value, 'amount' => $this->faker->randomFloat(3, 0, 99999)],
            ['code' => TaxCode::Isc->value, 'amount' => $this->faker->randomFloat(3, 0, 99999)],
        ];

        $taxes = Tax::query()->whereIn('code', Arr::pluck($itemTaxes, 'code'))->get();

        $service = app(InvoiceItemService::class);
        $service->setInvoiceItem($invoiceItem);
        $service->addTaxes($itemTaxes);

        foreach ($taxes as $tax) {
            $this->assertDatabaseHas(
                'invoice_item_tax',
                [
                    'item_id' => $invoiceItem->getKey(),
                    'tax_id' => $tax->getKey(),
                ]
            );
        }
    }

    public function testDeleteInvoiceItem()
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
        $invoice = Invoice::factory()
            ->for($transactionType)
            ->for($documentType)
            ->for($currency)
            ->for($issuer)
            ->for($acquirer)
            ->for($user)
            ->createOne();
        $invoiceItem = InvoiceItem::factory()
            ->for($invoice)
            ->createOne();

        $service = app(InvoiceItemService::class);
        $service->setInvoiceItem($invoiceItem);

        $itemTaxes = [
            ['code' => TaxCode::Igv->value, 'amount' => $this->faker->randomFloat(3, 0, 99999)],
            ['code' => TaxCode::Isc->value, 'amount' => $this->faker->randomFloat(3, 0, 99999)],
        ];

        $service->addTaxes($itemTaxes);

        $service->delete();

        $this->assertDatabaseMissing('invoice_items', ['id' => $invoiceItem->getKey()]);
        $this->assertDatabaseMissing('invoice_item_tax', ['item_id' => $invoiceItem->getKey()]);
    }
}
