<?php

namespace App\DataTransferObjects\Invoices;

class InvoiceTotalAmount
{
    public function __construct(
        public readonly string $currencyCode,
        public readonly float $value
    ) {
    }
}
