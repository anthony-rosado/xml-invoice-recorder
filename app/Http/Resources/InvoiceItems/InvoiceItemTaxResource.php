<?php

namespace App\Http\Resources\InvoiceItems;

use App\Models\InvoiceItemTax;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItemTaxResource extends JsonResource
{
    /**
     * @var Tax
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var InvoiceItemTax $pivot */
        $pivot = $this->resource->pivot;

        return [
            'code' => $this->resource->code,
            'name' => $this->resource->name,
            'amount' => $pivot->amount,
        ];
    }
}
