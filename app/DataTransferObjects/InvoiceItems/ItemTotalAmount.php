<?php

namespace App\DataTransferObjects\InvoiceItems;

class ItemTotalAmount
{
    public function __construct(
        public readonly string $currencyCode,
        public readonly float $value
    ) {
    }
}
