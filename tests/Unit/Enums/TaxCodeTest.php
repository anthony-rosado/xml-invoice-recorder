<?php

namespace Tests\Unit\Enums;

use App\Enums\TaxCode;
use App\Exceptions\Enums\UnexpectedTaxCodeValue;
use PHPUnit\Framework\TestCase;

class TaxCodeTest extends TestCase
{
    public function testThatEnumCanBeInstantiatedFromValidStringCode(): void
    {
        $taxCode = TaxCode::fromString('1000');

        $this->assertIsObject($taxCode);
        $this->assertInstanceOf(TaxCode::class, $taxCode);
        $this->assertTrue($taxCode === TaxCode::Igv);
    }

    public function testThatEnumCanNotBeInstantiatedFromInvalidStringCode(): void
    {
        $this->expectException(UnexpectedTaxCodeValue::class);

        TaxCode::fromString('8483');
    }

    public function testThatALabelCanBeObtainedFromEnumInstance()
    {
        $TaxCodeLabel = TaxCode::Isc->label();

        self::assertIsString($TaxCodeLabel);
    }
}
