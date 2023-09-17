<?php

namespace Tests\Feature\Services;

use App\Models\Acquirer;
use App\Models\Identification;
use App\Models\IdentificationType;
use App\Models\Issuer;
use App\Services\IdentificationService;
use Tests\TestCase;

class IdentificationServiceTest extends TestCase
{
    public function testCreateIdentificationForAcquirer(): void
    {
        $identification = Identification::factory()->makeOne();
        $identificationType = IdentificationType::query()->inRandomOrder()->first();
        $acquirer = Acquirer::factory()->createOne();

        $this->assertDatabaseMissing(
            'identifications',
            [
                'type_id' => $identificationType->getKey(),
                'value' => $identification->value,
                'identifiable_type' => $acquirer->getMorphClass(),
                'identifiable_id' => $acquirer->getKey(),
            ]
        );

        $service = app(IdentificationService::class);
        $service->create($identification->only(['value']), $identificationType, $acquirer);

        $this->assertDatabaseHas(
            'identifications',
            [
                'type_id' => $identificationType->getKey(),
                'value' => $identification->value,
                'identifiable_type' => $acquirer->getMorphClass(),
                'identifiable_id' => $acquirer->getKey(),
            ]
        );
    }

    public function testCreateIdentificationForIssuer(): void
    {
        $identification = Identification::factory()->makeOne();
        $identificationType = IdentificationType::query()->inRandomOrder()->first();
        $issuer = Issuer::factory()->createOne();

        $this->assertDatabaseMissing(
            'identifications',
            [
                'type_id' => $identificationType->getKey(),
                'value' => $identification->value,
                'identifiable_type' => $issuer->getMorphClass(),
                'identifiable_id' => $issuer->getKey(),
            ]
        );

        $service = app(IdentificationService::class);
        $service->create($identification->only(['value']), $identificationType, $issuer);

        $this->assertDatabaseHas(
            'identifications',
            [
                'type_id' => $identificationType->getKey(),
                'value' => $identification->value,
                'identifiable_type' => $issuer->getMorphClass(),
                'identifiable_id' => $issuer->getKey(),
            ]
        );
    }
}
