<?php

namespace App\Http\Resources\Invoices;

use App\DataTransferObjects\Invoices\InvoiceTotalAmount;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceTotalAmountResource extends JsonResource
{
    /**
     * @var InvoiceTotalAmount
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
