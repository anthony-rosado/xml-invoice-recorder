<?php

namespace Tests\Feature\Helpers;

use App\Exceptions\Helpers\CouldNotTransformInvoiceXmlToArrayException;
use App\Helpers\InvoiceXmlToArray;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InvoiceXmlToArrayTest extends TestCase
{
    public function testTransformInvoiceXmlContentToArray(): void
    {
        $rawContent = Storage::get('/invoices/F003-1.xml');

        $helper = new InvoiceXmlToArray($rawContent);

        $invoiceData = $helper->transform();

        self::assertIsArray($invoiceData);

        $keys = [
            'transaction_type_code',
            'document_type_code',
            'currency_code',
            'series',
            'correlative_number',
            'issue_date',
            'issue_time',
            'due_date',
            'observation',
            'base_amount',
            'tax_amount',
            'discount_amount',
            'other_charges_amount',
            'total_amount',
            'issuer',
            'acquirer',
            'taxes',
            'items',
        ];

        foreach ($keys as $key) {
            self::assertArrayHasKey($key, $invoiceData);
        }
    }

    public function testUnableToTransformInvoiceXmlContentToArray(): void
    {
        $rawContent = Storage::get('/invoices/MISSING-ID.xml');

        $this->expectException(CouldNotTransformInvoiceXmlToArrayException::class);

        $helper = new InvoiceXmlToArray($rawContent);

        $helper->transform();
    }
}
