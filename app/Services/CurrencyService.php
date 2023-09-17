<?php

namespace App\Services;

use App\Models\Currency;

class CurrencyService
{
    public static function findByCode(string $code): Currency
    {
        /** @var Currency $currency */
        $currency = Currency::query()
            ->where('code', '=', $code)
            ->firstOrFail();

        return $currency;
    }
}
