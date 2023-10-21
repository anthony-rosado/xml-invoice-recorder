<?php

namespace App\Http\Resources\InvoiceItems;

use App\DataTransferObjects\InvoiceItems\TotalAccumulatedPerItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TotalAccumulatedItemResource extends JsonResource
{
    /**
     * @var TotalAccumulatedPerItem
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
            'amounts' => ItemAmountResource::collection($this->resource->amounts),
        ];
    }
}
