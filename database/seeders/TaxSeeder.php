<?php

namespace Database\Seeders;

use App\Contracts\TaxCode;
use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxes = [
            [
                'code' => TaxCode::Igv->value,
                'name' => __('taxes.code_names.igv', [], 'es'),
            ],
            [
                'code' => TaxCode::Isc->value,
                'name' => __('taxes.code_names.isc', [], 'es'),
            ],
            [
                'code' => TaxCode::Free->value,
                'name' => __('taxes.code_names.free', [], 'es'),
            ],
            [
                'code' => TaxCode::Exonerated->value,
                'name' => __('taxes.code_names.exonerated', [], 'es'),
            ],
            [
                'code' => TaxCode::Unaffected->value,
                'name' => __('taxes.code_names.unaffected', [], 'es'),
            ],
            [
                'code' => TaxCode::Other->value,
                'name' => __('taxes.code_names.other', [], 'es'),
            ],
        ];

        foreach ($taxes as $tax) {
            Tax::query()->create($tax);
        }
    }
}
