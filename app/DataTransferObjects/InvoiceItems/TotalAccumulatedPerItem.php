<?php

namespace App\DataTransferObjects\InvoiceItems;

class TotalAccumulatedPerItem
{
    /**
     * @param string $code
     * @param ItemTotalAmount[] $amounts
     */
    public function __construct(
        public readonly string $code,
        public readonly array $amounts
    ) {
    }
}
