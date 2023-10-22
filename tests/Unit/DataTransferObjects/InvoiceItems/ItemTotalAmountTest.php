<?php

namespace Tests\Unit\DataTransferObjects\InvoiceItems;

use App\DataTransferObjects\InvoiceItems\ItemTotalAmount;
use PHPUnit\Framework\TestCase;

class ItemTotalAmountTest extends TestCase
{
    public function testInstance()
    {
        $itemAmount = new ItemTotalAmount('PEN', 834.9);

        self::assertInstanceOf(ItemTotalAmount::class, $itemAmount);
        self::assertSame('PEN', $itemAmount->currencyCode);
        self::assertSame(834.9, $itemAmount->value);
    }
}
