<?php

namespace App\Http\Resources\Identifications;

use App\Http\Resources\IdentificationTypes\IdentificationTypeResource;
use App\Models\Identification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IdentificationResource extends JsonResource
{
    /**
     * @var Identification
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
            'value' => $this->resource->value,
            'type' => IdentificationTypeResource::make($this->resource->type),
        ];
    }
}
