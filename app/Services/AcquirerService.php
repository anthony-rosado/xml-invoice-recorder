<?php

namespace App\Services;

use App\Models\Acquirer;

class AcquirerService
{
    private Acquirer $acquirer;

    public function setAcquirer(Acquirer $acquirer): void
    {
        $this->acquirer = $acquirer;
    }

    public function getAcquirer(): Acquirer
    {
        return $this->acquirer;
    }

    public function create(array $attributes): void
    {
        /** @var Acquirer $acquirer */
        $acquirer = Acquirer::query()->create($attributes);

        $this->setAcquirer($acquirer);
    }

    public function addIdentification(array $identification): void
    {
        $type = IdentificationTypeService::findByCode($identification['code']);

        $identificationService = new IdentificationService();
        $identificationService->create(['value' => $identification['value']], $type, $this->getAcquirer());
    }
}
