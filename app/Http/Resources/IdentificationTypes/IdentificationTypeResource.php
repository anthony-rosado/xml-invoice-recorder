<?php

namespace App\Http\Resources\IdentificationTypes;

use App\Models\IdentificationType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IdentificationTypeResource extends JsonResource
{
    /**
     * @var IdentificationType
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
            'code' => $this->resource->code,
            'name' => $this->resource->name,
        ];
    }
}
