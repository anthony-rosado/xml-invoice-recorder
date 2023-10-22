<?php

namespace App\Http\Resources\Issuers;

use App\Http\Resources\Identifications\IdentificationResource;
use App\Models\Issuer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IssuerResource extends JsonResource
{
    /**
     * @var Issuer
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'company_name' => $this->resource->company_name,
            'trade_name' => $this->resource->trade_name,
            'identification' => IdentificationResource::make($this->resource->identification),
        ];
    }
}
