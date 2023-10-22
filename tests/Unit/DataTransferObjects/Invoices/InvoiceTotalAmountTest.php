<?php

namespace Tests\Unit\DataTransferObjects\Invoices;

use App\DataTransferObjects\Invoices\InvoiceTotalAmount;
use PHPUnit\Framework\TestCase;

class InvoiceTotalAmountTest extends TestCase
{
    public function testInstance()
    {
        $invoiceTotalAmount = new InvoiceTotalAmount('PEN', 1534.9);

        self::assertInstanceOf(InvoiceTotalAmount::class, $invoiceTotalAmount);
        self::assertSame('PEN', $invoiceTotalAmount->currencyCode);
        self::assertSame(1534.9, $invoiceTotalAmount->value);
    }
}
