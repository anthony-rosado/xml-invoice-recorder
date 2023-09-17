<?php

namespace Tests\Feature\Handlers;

use App\Exceptions\Handlers\Invoices\CouldNotRecordInvoice;
use App\Exceptions\Handlers\Invoices\InvoiceAlreadyRecorded;
use App\Handlers\Invoices\RecordInvoice;
use App\Models\Acquirer;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\Invoice;
use App\Models\Issuer;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RecordInvoiceTest extends TestCase
{
    public function testPerformRecordInvoice(): void
    {
        $rawContent = Storage::get('/invoices/F003-1.xml');
        $user = User::factory()->createOne();

        $handler = app(RecordInvoice::class);
        $invoice = $handler->perform($rawContent, $user);

        self::assertInstanceOf(Invoice::class, $invoice);

        $this->assertDatabaseHas('invoices', [
            'series' => 'F003',
            'correlative_number' => 1,
        ]);
    }

    public function testUnableToPerformRecordAnExistingInvoice(): void
    {
        $rawContent = Storage::get('/invoices/F003-2.xml');
        $transactionType = TransactionType::query()->inRandomOrder()->first();
        $documentType = DocumentType::query()->inRandomOrder()->first();
        $currency = Currency::query()->inRandomOrder()->first();
        $issuer = Issuer::factory()->createOne();
        $acquirer = Acquirer::factory()->createOne();
        $user = User::factory()->createOne();
        Invoice::factory()
            ->for($transactionType)
            ->for($documentType)
            ->for($currency)
            ->for($issuer)
            ->for($acquirer)
            ->for($user)
            ->createOne(['series' => 'F003', 'correlative_number' => 2]);

        $this->expectException(InvoiceAlreadyRecorded::class);

        app(RecordInvoice::class)->perform($rawContent, $user);
    }

    public function testUnableToPerformRecordInvoiceDueInternalError(): void
    {
        $rawContent = Storage::get('/invoices/F003-2.xml');
        $user = User::factory()->makeOne();

        $this->expectException(CouldNotRecordInvoice::class);

        app(RecordInvoice::class)->perform($rawContent, $user);
    }
}
