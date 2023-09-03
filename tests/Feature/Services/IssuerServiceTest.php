<?php

namespace Tests\Feature\Services;

use App\Enums\IdentificationTypeCode;
use App\Models\Issuer;
use App\Services\IssuerService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IssuerServiceTest extends TestCase
{
    use WithFaker;

    public function testCreateAnIssuer(): void
    {
        $issuer = Issuer::factory()->makeOne();

        app(IssuerService::class)->create($issuer->only(['company_name', 'trade_name']));

        $this->assertDatabaseHas('issuers', $issuer->only(['company_name', 'trade_name']));
    }

    public function testCreateAnIssuerWithIdentification(): void
    {
        $issuer = Issuer::factory()->makeOne();

        $issuerIdentification = [
            'code' => IdentificationTypeCode::Dni->value,
            'value' => $this->faker->randomNumber(9),
        ];

        $service = app(IssuerService::class);
        $service->create($issuer->only(['company_name', 'trade_name']));
        $service->addIdentification($issuerIdentification);

        $this->assertDatabaseHas('issuers', $issuer->only(['company_name', 'trade_name']));
        $this->assertDatabaseHas(
            'identifications',
            [
                'value' => $issuerIdentification['value'],
                'identifiable_type' => $service->getIssuer()->getMorphClass(),
                'identifiable_id' => $service->getIssuer()->getKey(),
            ]
        );
    }
}
