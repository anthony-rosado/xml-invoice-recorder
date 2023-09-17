<?php

namespace Tests\Feature\Services;

use App\Enums\CurrencyCode;
use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class CurrencyServiceTest extends TestCase
{
    public function testFindCurrencyWithValidCode(): void
    {
        $code = CurrencyCode::Pen;

        $this->assertDatabaseHas('currencies', ['code' => $code->value]);

        $currency = CurrencyService::findByCode($code->value);

        self::assertInstanceOf(Currency::class, $currency);
        self::assertSame($code->value, $currency->code);
    }

    public function testUnableToFindCurrencyWithInvalidCode(): void
    {
        $code = 'SQL';

        $this->assertDatabaseMissing('currencies', ['code' => $code]);

        $this->expectException(ModelNotFoundException::class);

        CurrencyService::findByCode($code);
    }
}
