<?php

namespace Tests\Unit\Enums;

use App\Enums\IdentificationTypeCode;
use App\Exceptions\Enums\UnexpectedIdentificationTypeCodeValue;
use PHPUnit\Framework\TestCase;

class IdentificationTypeCodeTest extends TestCase
{
    public function testThatEnumCanBeInstantiatedFromValidStringCode(): void
    {
        $identificationTypeCode = IdentificationTypeCode::fromString('1');

        $this->assertIsObject($identificationTypeCode);
        $this->assertInstanceOf(IdentificationTypeCode::class, $identificationTypeCode);
        $this->assertTrue($identificationTypeCode === IdentificationTypeCode::Dni);
    }

    public function testThatEnumCanNotBeInstantiatedFromInvalidStringCode(): void
    {
        $this->expectException(UnexpectedIdentificationTypeCodeValue::class);

        IdentificationTypeCode::fromString('X');
    }

    public function testThatALabelCanBeObtainedFromEnumInstance()
    {
        $identificationTypeCodeLabel = IdentificationTypeCode::Ruc->label();

        self::assertIsString($identificationTypeCodeLabel);
    }
}
