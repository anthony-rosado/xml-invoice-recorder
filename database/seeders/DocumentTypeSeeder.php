<?php

namespace Database\Seeders;

use App\Enums\DocumentTypeCode;
use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            [
                'code' => DocumentTypeCode::Bill->value,
                'name' => __('document_types.code_names.bill', [], 'es'),
            ],
        ];

        foreach ($documentTypes as $documentType) {
            DocumentType::query()->create($documentType);
        }
    }
}
