<?php

namespace Tests\Feature\Services;

use App\Enums\IdentificationTypeCode;
use App\Models\IdentificationType;
use App\Services\IdentificationTypeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class IdentificationTypeServiceTest extends TestCase
{
    public function testFindIdentificationTypeWithValidCode(): void
    {
        $code = IdentificationTypeCode::Passport;

        $this->assertDatabaseHas('identification_types', ['code' => $code->value]);

        $identificationType = IdentificationTypeService::findByCode($code->value);

        self::assertInstanceOf(IdentificationType::class, $identificationType);
        self::assertSame($code->value, $identificationType->code);
    }

    public function testUnableToFindIdentificationTypeWithInvalidCode(): void
    {
        $code = '9';

        $this->assertDatabaseMissing('identification_types', ['code' => $code]);

        $this->expectException(ModelNotFoundException::class);

        IdentificationTypeService::findByCode($code);
    }
}
