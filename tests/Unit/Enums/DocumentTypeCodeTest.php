<?php

namespace Tests\Unit\Enums;

use App\Enums\DocumentTypeCode;
use App\Exceptions\Enums\UnexpectedDocumentTypeCodeValue;
use PHPUnit\Framework\TestCase;

class DocumentTypeCodeTest extends TestCase
{
    public function testThatEnumCanBeInstantiatedFromValidStringCode(): void
    {
        $documentTypeCode = DocumentTypeCode::fromString('01');

        $this->assertIsObject($documentTypeCode);
        $this->assertInstanceOf(DocumentTypeCode::class, $documentTypeCode);
        $this->assertTrue($documentTypeCode === DocumentTypeCode::Bill);
    }

    public function testThatEnumCanNotBeInstantiatedFromInvalidStringCode(): void
    {
        $this->expectException(UnexpectedDocumentTypeCodeValue::class);

        DocumentTypeCode::fromString('09');
    }

    public function testThatALabelCanBeObtainedFromEnumInstance()
    {
        $documentTypeCodeLabel = DocumentTypeCode::Bill->label();

        self::assertIsString($documentTypeCodeLabel);
    }
}
