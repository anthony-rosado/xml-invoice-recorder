<?php

namespace App\Http\Resources\Acquirers;

use App\Http\Resources\Identifications\IdentificationResource;
use App\Models\Acquirer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcquirerResource extends JsonResource
{
    /**
     * @var Acquirer
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
            'identification' => IdentificationResource::make($this->resource->identification),
        ];
    }
}
