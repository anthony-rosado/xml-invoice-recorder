<?php

namespace Database\Seeders;

use App\Contracts\CurrencyCode;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'code' => CurrencyCode::Pen->value,
                'name' => __('currencies.code_names.peruvian_sol', [], 'es'),
            ],
            [
                'code' => CurrencyCode::Usd->value,
                'name' => __('currencies.code_names.american_dollar', [], 'es'),
            ],
            [
                'code' => CurrencyCode::Eur->value,
                'name' => __('currencies.code_names.euro', [], 'es'),
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::query()->create($currency);
        }
    }
}
