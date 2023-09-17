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
use App\Services\InvoiceService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class InvoiceServiceTest extends TestCase
{
    use WithFaker;

    public function testCheckInvoiceByReferenceIfExists(): void
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

        $service = app(InvoiceService::class);

        $this->assertTrue($service->checkByReferenceIfExists($invoice->series, $invoice->correlative_number));
    }

    public function testCreateInvoice(): void
    {
        $invoice = Invoice::factory()->makeOne();
        $transactionType = TransactionType::query()->inRandomOrder()->first();
        $documentType = DocumentType::query()->inRandomOrder()->first();
        $currency = Currency::query()->inRandomOrder()->first();
        $issuer = Issuer::factory()->createOne();
        $acquirer = Acquirer::factory()->createOne();
        $user = User::factory()->createOne();

        $service = app(InvoiceService::class);
        $service->create(
            $invoice->attributesToArray(),
            $transactionType,
            $documentType,
            $currency,
            $issuer,
            $acquirer,
            $user
        );

        $this->assertDatabaseHas('invoices', $invoice->only(['series', 'correlative_number']));
    }

    public function testAddTaxesToInvoice()
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
        $invoiceTaxes = [
            ['code' => TaxCode::Igv->value, 'amount' => $this->faker->randomFloat(3, 0, 99999)],
            ['code' => TaxCode::Isc->value, 'amount' => $this->faker->randomFloat(3, 0, 99999)],
        ];

        $taxes = Tax::query()->whereIn('code', Arr::pluck($invoiceTaxes, 'code'))->get();

        $service = app(InvoiceService::class);
        $service->setInvoice($invoice);
        $service->addTaxes($invoiceTaxes);

        foreach ($taxes as $tax) {
            $this->assertDatabaseHas(
                'invoice_tax',
                [
                    'invoice_id' => $service->getInvoice()->getKey(),
                    'tax_id' => $tax->getKey(),
                ]
            );
        }
    }

    public function testAddItemsToInvoice()
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
        $items = InvoiceItem::factory()->count(5)->make();
        $itemTaxes = [
            ['code' => TaxCode::Igv->value, 'amount' => $this->faker->randomFloat(3, 0, 99999)],
            ['code' => TaxCode::Isc->value, 'amount' => $this->faker->randomFloat(3, 0, 99999)],
        ];
        foreach ($items as $item) {
            $item->taxes = $itemTaxes;
        }

        $taxes = Tax::query()->whereIn('code', Arr::pluck($itemTaxes, 'code'))->get();

        $service = app(InvoiceService::class);
        $service->setInvoice($invoice);
        $service->addItems($items->toArray());

        $invoiceItems = $service->getInvoice()->items()->get();

        foreach ($invoiceItems as $invoiceItem) {
            $this->assertDatabaseHas(
                'invoice_items',
                [
                    'code' => $invoiceItem->code,
                    'invoice_id' => $service->getInvoice()->getKey(),
                ]
            );

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
    }
}
