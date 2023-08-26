<?php

namespace Tests\Unit\Enums;

use App\Enums\CurrencyCode;
use App\Exceptions\Enums\UnexpectedCurrencyCodeValue;
use PHPUnit\Framework\TestCase;

class CurrencyCodeTest extends TestCase
{
    public function testThatEnumCanBeInstantiatedFromValidStringCode(): void
    {
        $currencyCode = CurrencyCode::fromString('PEN');

        self::assertIsObject($currencyCode);
        self::assertInstanceOf(CurrencyCode::class, $currencyCode);
        self::assertTrue($currencyCode === CurrencyCode::Pen);
    }

    public function testThatEnumCanNotBeInstantiatedFromInvalidStringCode(): void
    {
        self::expectException(UnexpectedCurrencyCodeValue::class);

        CurrencyCode::fromString('MKL');
    }

    public function testThatALabelCanBeObtainedFromEnumInstance()
    {
        $currencyCodeLabel = CurrencyCode::Usd->label();

        self::assertIsString($currencyCodeLabel);
    }
}
