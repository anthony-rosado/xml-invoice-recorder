<?php

namespace App\Http\Resources\InvoiceItems;

use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItemResource extends JsonResource
{
    /**
     * @var InvoiceItem
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
            'id' => $this->resource->id,
            'code' => $this->resource->code,
            'description' => $this->resource->description,
            'quantity' => $this->resource->quantity,
            'unit_value' => $this->resource->unit_value,
            'unit_price' => $this->resource->unit_price,
            'base_amount' => $this->resource->base_amount,
            'tax_amount' => $this->resource->tax_amount,
            'discount_amount' => $this->resource->discount_amount,
            'other_charges_amount' => $this->resource->other_charges_amount,
            'total_amount' => $this->resource->total_amount,
            'taxes' => InvoiceItemTaxResource::collection($this->resource->taxes),
        ];
    }
}
