<?php

namespace Tests\Feature\Http\Controllers\Invoices;

use App\Models\Acquirer;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\Identification;
use App\Models\IdentificationType;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Issuer;
use App\Models\Tax;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetInvoiceControllerTest extends TestCase
{
    use WithFaker;

    public function testGetInvoiceDetail(): void
    {
        $randomTax = Tax::query()->inRandomOrder()->first();
        $issuer = Issuer::factory()->createOne();
        Identification::factory()
            ->for($issuer, 'identifiable')
            ->for(IdentificationType::query()->inRandomOrder()->first(), 'type')
            ->createOne();
        $acquirer = Acquirer::factory()->createOne();
        Identification::factory()
            ->for($acquirer, 'identifiable')
            ->for(IdentificationType::query()->inRandomOrder()->first(), 'type')
            ->createOne();
        $user = User::factory()->createOne();

        $invoice = Invoice::factory()
            ->for(TransactionType::query()->inRandomOrder()->first())
            ->for(DocumentType::query()->inRandomOrder()->first())
            ->for(Currency::query()->inRandomOrder()->first())
            ->for($issuer)
            ->for($acquirer)
            ->for($user)
            ->has(
                InvoiceItem::factory()
                    ->hasAttached(
                        $randomTax,
                        ['amount' => $this->faker->randomFloat(3, 0, 99999)],
                        'taxes'
                    )
                    ->count(3),
                'items'
            )
            ->hasAttached(
                $randomTax,
                ['amount' => $this->faker->randomFloat(3, 0, 99999)],
                'taxes'
            )
            ->createOne();

        Passport::actingAs($user);

        $response = $this->getJson('/api/invoices/' . $invoice->id);

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json) => $json
                ->has(
                    'data',
                    fn (AssertableJson $json) => $json
                        ->hasAll([
                            'id',
                            'series',
                            'correlative_number',
                            'reference',
                            'issue_date',
                            'issue_time',
                            'issue_at',
                            'due_date',
                            'observation',
                            'base_amount',
                            'tax_amount',
                            'base_tax_amount',
                            'discount_amount',
                            'other_charges_amount',
                            'global_discount_amount',
                            'total_amount',
                            'transaction_type',
                            'transaction_type.code',
                            'transaction_type.name',
                            'document_type',
                            'document_type.code',
                            'document_type.name',
                            'currency',
                            'currency.code',
                            'currency.name',
                            'acquirer',
                            'acquirer.company_name',
                            'acquirer.identification',
                            'acquirer.identification.value',
                            'acquirer.identification.type',
                            'acquirer.identification.type.code',
                            'acquirer.identification.type.name',
                            'issuer',
                            'issuer.company_name',
                            'issuer.trade_name',
                            'issuer.identification',
                            'issuer.identification.value',
                            'issuer.identification.type',
                            'issuer.identification.type.code',
                            'issuer.identification.type.name',
                            'user',
                            'user.name',
                            'taxes',
                            'items',
                        ])
                        ->whereAllType([
                            'id' => 'integer',
                            'series' => 'string',
                            'correlative_number' => 'integer',
                            'reference' => 'string',
                            'issue_date' => 'string',
                            'issue_time' => 'string',
                            'issue_at' => 'string',
                            'due_date' => 'string',
                            'observation' => ['string', 'null'],
                            'base_amount' => 'string',
                            'tax_amount' => 'string',
                            'base_tax_amount' => 'string',
                            'discount_amount' => 'string',
                            'other_charges_amount' => 'string',
                            'global_discount_amount' => 'string',
                            'total_amount' => 'string',
                            'transaction_type' => 'array',
                            'transaction_type.code' => 'string',
                            'transaction_type.name' => 'string',
                            'document_type' => 'array',
                            'document_type.code' => 'string',
                            'document_type.name' => 'string',
                            'currency' => 'array',
                            'currency.code' => 'string',
                            'currency.name' => 'string',
                            'acquirer' => 'array',
                            'acquirer.company_name' => 'string',
                            'acquirer.identification' => 'array',
                            'acquirer.identification.value' => 'string',
                            'acquirer.identification.type' => 'array',
                            'acquirer.identification.type.code' => 'string',
                            'acquirer.identification.type.name' => 'string',
                            'issuer' => 'array',
                            'issuer.company_name' => 'string',
                            'issuer.trade_name' => 'string',
                            'issuer.identification' => 'array',
                            'issuer.identification.value' => 'string',
                            'issuer.identification.type' => 'array',
                            'issuer.identification.type.code' => 'string',
                            'issuer.identification.type.name' => 'string',
                            'user' => 'array',
                            'user.name' => 'string',
                            'taxes' => 'array',
                            'items' => 'array',
                        ])
                )
        );
    }
}
