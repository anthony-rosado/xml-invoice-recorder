<?php

namespace App\Http\Resources\Invoices;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceSmallResource extends JsonResource
{
    /**
     * @var Invoice
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
            'series' => $this->resource->series,
            'correlative_number' => $this->resource->correlative_number,
            'issue_date' => $this->resource->issue_date,
            'issue_time' => $this->resource->issue_time,
            'due_date' => $this->resource->due_date,
            'total_amount' => $this->resource->total_amount,
            'items_count' => $this->resource->items_count ?? 0,
        ];
    }
}
