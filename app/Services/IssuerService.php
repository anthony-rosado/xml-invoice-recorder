<?php

namespace App\Services;

use App\Models\Issuer;

class IssuerService
{
    private Issuer $issuer;

    public function setIssuer(Issuer $issuer): void
    {
        $this->issuer = $issuer;
    }

    public function getIssuer(): Issuer
    {
        return $this->issuer;
    }

    public function create(array $attributes): void
    {
        /** @var Issuer $acquirer */
        $acquirer = Issuer::query()->create($attributes);

        $this->setIssuer($acquirer);
    }

    public function addIdentification(array $identification): void
    {
        $type = IdentificationTypeService::findByCode($identification['code']);

        $identificationService = new IdentificationService();
        $identificationService->create(['value' => $identification['value']], $type, $this->getIssuer());
    }
}
