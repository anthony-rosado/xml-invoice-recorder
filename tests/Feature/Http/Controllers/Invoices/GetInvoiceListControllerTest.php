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

class GetInvoiceListControllerTest extends TestCase
{
    public function testGetInvoiceList(): void
    {
        $transactionType = TransactionType::query()->inRandomOrder()->first();
        $documentType = DocumentType::query()->inRandomOrder()->first();
        $currency = Currency::query()->inRandomOrder()->first();
        $issuer = Issuer::factory()->createOne();
        $acquirer = Acquirer::factory()->createOne();
        $user = User::factory()->createOne();
        $invoiceItems = InvoiceItem::factory()->count(3);
        Invoice::factory()
            ->for($transactionType)
            ->for($documentType)
            ->for($currency)
            ->for($issuer)
            ->for($acquirer)
            ->for($user)
            ->has($invoiceItems, 'items')
            ->createMany(6);

        Passport::actingAs(User::factory()->createOne());

        $response = $this->getJson('/api/invoices');

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json) => $json
                ->has(
                    'data',
                    6,
                    fn (AssertableJson $json) => $json
                        ->hasAll([
                            'id',
                            'series',
                            'correlative_number',
                            'issue_date',
                            'issue_time',
                            'due_date',
                            'total_amount',
                            'items_count',
                        ])
                        ->whereAllType([
                            'id' => 'integer',
                            'series' => 'string',
                            'correlative_number' => 'integer',
                            'issue_date' => 'string',
                            'issue_time' => 'string',
                            'due_date' => 'string',
                            'total_amount' => 'string',
                            'items_count' => 'integer',
                        ])
                )
                ->has('meta')
                ->has('links')
                ->whereAllType([
                    'data' => 'array',
                    'meta' => 'array',
                    'links' => 'array',
                ])
        );
    }

    public function testGetEmptyInvoiceList(): void
    {
        Passport::actingAs(User::factory()->createOne());

        $response = $this->getJson('/api/invoices');

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json) => $json
                ->has('data', 0)
                ->has('meta')
                ->has('links')
                ->whereAllType([
                    'data' => 'array',
                    'meta' => 'array',
                    'links' => 'array',
                ])
        );
    }

    public function testTryingToGetInvoiceListWithNoAuthentication(): void
    {
        $response = $this->getJson('/api/invoices');

        self::assertNotTrue($this->isAuthenticated());

        $response->assertUnauthorized()
            ->assertJson(
                fn (AssertableJson $json) => $json->has('message')
                    ->whereType('message', 'string')
            );
    }
}
