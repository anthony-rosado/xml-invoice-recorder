<?php

namespace Tests\Unit\DataTransferObjects\InvoiceItems;

use App\DataTransferObjects\InvoiceItems\ItemTotalAmount;
use App\DataTransferObjects\InvoiceItems\TotalAccumulatedPerItem;
use Tests\TestCase;

class TotalAccumulatedPerItemTest extends TestCase
{
    public function testInstance()
    {
        $totalAccumulatedPerItem = new TotalAccumulatedPerItem(
            'FTG',
            [
                new ItemTotalAmount('PEN', 123.92),
                new ItemTotalAmount('USD', 943.45),
            ]
        );

        self::assertInstanceOf(TotalAccumulatedPerItem::class, $totalAccumulatedPerItem);
        self::assertSame('FTG', $totalAccumulatedPerItem->code);
        self::assertCount(2, $totalAccumulatedPerItem->amounts);
    }
}
