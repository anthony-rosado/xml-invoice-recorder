<?php

namespace Tests\Feature\Services;

use App\Enums\TaxCode;
use App\Models\Tax;
use App\Services\TaxService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class TaxServiceTest extends TestCase
{
    public function testFindTaxWithValidCode(): void
    {
        $code = TaxCode::Igv;

        $this->assertDatabaseHas('taxes', ['code' => $code->value]);

        $tax = TaxService::findByCode($code->value);

        self::assertInstanceOf(Tax::class, $tax);
        self::assertSame($code->value, $tax->code);
    }

    public function testUnableToFindTaxWithInvalidCode(): void
    {
        $code = '3000';

        $this->assertDatabaseMissing('taxes', ['code' => $code]);

        $this->expectException(ModelNotFoundException::class);

        TaxService::findByCode($code);
    }
}
