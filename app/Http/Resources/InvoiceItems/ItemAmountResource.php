<?php

namespace App\Http\Resources\InvoiceItems;

use App\DataTransferObjects\InvoiceItems\ItemTotalAmount;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemAmountResource extends JsonResource
{
    /**
     * @var ItemTotalAmount
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
            'currency_code' => $this->resource->currencyCode,
            'value' => $this->resource->value,
        ];
    }
}
