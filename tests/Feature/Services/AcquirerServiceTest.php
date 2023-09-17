<?php

namespace Tests\Feature\Services;

use App\Enums\IdentificationTypeCode;
use App\Models\Acquirer;
use App\Services\AcquirerService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AcquirerServiceTest extends TestCase
{
    use WithFaker;

    public function testCreateAnAcquirer(): void
    {
        $acquirer = Acquirer::factory()->makeOne();

        app(AcquirerService::class)->create($acquirer->only(['company_name']));

        $this->assertDatabaseHas('acquirers', $acquirer->only(['company_name']));
    }

    public function testCreateAnAcquirerWithIdentification(): void
    {
        $acquirer = Acquirer::factory()->makeOne();

        $acquirerIdentification = [
            'code' => IdentificationTypeCode::Dni->value,
            'value' => $this->faker->randomNumber(),
        ];

        $service = app(AcquirerService::class);
        $service->create($acquirer->only(['company_name']));
        $service->addIdentification($acquirerIdentification);

        $this->assertDatabaseHas('acquirers', $acquirer->only(['company_name']));
        $this->assertDatabaseHas(
            'identifications',
            [
                'value' => $acquirerIdentification['value'],
                'identifiable_type' => $service->getAcquirer()->getMorphClass(),
                'identifiable_id' => $service->getAcquirer()->getKey(),
            ]
        );
    }
}
