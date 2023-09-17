<?php

namespace App\Services;

use App\Models\Tax;

class TaxService
{
    public static function findByCode(string $code): Tax
    {
        /** @var Tax $tax */
        $tax = Tax::query()
            ->where('code', '=', $code)
            ->firstOrFail();

        return $tax;
    }
}
