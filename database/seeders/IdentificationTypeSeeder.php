<?php

namespace Database\Seeders;

use App\Enums\IdentificationTypeCode;
use App\Models\IdentificationType;
use Illuminate\Database\Seeder;

class IdentificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $identificationTypes = [
            [
                'code' => IdentificationTypeCode::NoDocument->value,
                'name' => __('identification_types.code_names.no_document', [], 'es'),
            ],
            [
                'code' => IdentificationTypeCode::Dni->value,
                'name' => __('identification_types.code_names.dni', [], 'es'),
            ],
            [
                'code' => IdentificationTypeCode::ForeignerCard->value,
                'name' => __('identification_types.code_names.foreigner_card', [], 'es'),
            ],
            [
                'code' => IdentificationTypeCode::Ruc->value,
                'name' => __('identification_types.code_names.ruc', [], 'es'),
            ],
            [
                'code' => IdentificationTypeCode::Passport->value,
                'name' => __('identification_types.code_names.passport', [], 'es'),
            ],
        ];

        foreach ($identificationTypes as $identificationType) {
            IdentificationType::query()->create($identificationType);
        }
    }
}
