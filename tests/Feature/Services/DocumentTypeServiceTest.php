<?php

namespace Tests\Feature\Services;

use App\Enums\DocumentTypeCode;
use App\Models\DocumentType;
use App\Services\DocumentTypeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class DocumentTypeServiceTest extends TestCase
{
    public function testFindDocumentTypeWithValidCode(): void
    {
        $code = DocumentTypeCode::Bill;

        $this->assertDatabaseHas('document_types', ['code' => $code->value]);

        $documentType = DocumentTypeService::findByCode($code->value);

        self::assertInstanceOf(DocumentType::class, $documentType);
        self::assertSame($code->value, $documentType->code);
    }

    public function testUnableToFindDocumentTypeWithInvalidCode(): void
    {
        $code = '10';

        $this->assertDatabaseMissing('document_types', ['code' => $code]);

        $this->expectException(ModelNotFoundException::class);

        DocumentTypeService::findByCode($code);
    }
}
