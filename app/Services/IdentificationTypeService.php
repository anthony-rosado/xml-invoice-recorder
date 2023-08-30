<?php

namespace App\Services;

use App\Models\IdentificationType;

class IdentificationTypeService
{
    public static function findByCode(string $code): IdentificationType
    {
        /** @var IdentificationType $identificationType */
        $identificationType = IdentificationType::query()
            ->where('code', '=', $code)
            ->firstOrFail();

        return $identificationType;
    }
}
