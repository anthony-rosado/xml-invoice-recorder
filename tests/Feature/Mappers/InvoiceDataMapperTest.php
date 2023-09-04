<?php

namespace Tests\Feature\Mappers;

use App\Exceptions\Mappers\UnableToGetElementFromData;
use App\Helpers\InvoiceXmlToArray;
use App\Mappers\InvoiceDataMapper;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InvoiceDataMapperTest extends TestCase
{
    public function testMapInvoiceData(): void
    {
        $rawContent = Storage::get('/invoices/F003-1.xml');

        $helper = new InvoiceXmlToArray($rawContent);

        $invoiceData = $helper->transform();

        $mapper = new InvoiceDataMapper($invoiceData);

        self::assertIsArray($mapper->getAttributes());
        self::assertIsString($mapper->getTransactionTypeCode());
        self::assertIsString($mapper->getDocumentTypeCode());
        self::assertIsString($mapper->getCurrencyCode());
        self::assertIsArray($mapper->getIssuer());
        self::assertIsArray($mapper->getAcquirer());
        self::assertIsArray($mapper->getTaxes());
        self::assertIsArray($mapper->getItems());
    }

    public function testErrorMapInvoiceData(): void
    {
        $invoice = Invoice::factory()->makeOne();

        $mapper = new InvoiceDataMapper($invoice->attributesToArray());

        $this->expectException(UnableToGetElementFromData::class);

        $mapper->getAttributes();
        $mapper->getTransactionTypeCode();
        $mapper->getDocumentTypeCode();
        $mapper->getCurrencyCode();
        $mapper->getIssuer();
        $mapper->getAcquirer();
        $mapper->getTaxes();
        $mapper->getItems();
    }
}
