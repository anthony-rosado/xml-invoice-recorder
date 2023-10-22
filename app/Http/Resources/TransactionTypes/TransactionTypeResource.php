<?php

namespace App\Http\Resources\TransactionTypes;

use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionTypeResource extends JsonResource
{
    /**
     * @var TransactionType
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
