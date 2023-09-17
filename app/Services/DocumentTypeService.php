<?php

namespace App\Services;

use App\Models\DocumentType;

class DocumentTypeService
{
    public static function findByCode(string $code): DocumentType
    {
        /** @var DocumentType $documentType */
        $documentType = DocumentType::query()
            ->where('code', '=', $code)
            ->firstOrFail();

        return $documentType;
    }
}
