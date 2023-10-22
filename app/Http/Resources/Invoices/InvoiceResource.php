<?php

namespace App\Http\Resources\Invoices;

use App\Http\Resources\Acquirers\AcquirerResource;
use App\Http\Resources\Currencies\CurrencyResource;
use App\Http\Resources\DocumentTypes\DocumentTypeResource;
use App\Http\Resources\InvoiceItems\InvoiceItemResource;
use App\Http\Resources\Issuers\IssuerResource;
use App\Http\Resources\TransactionTypes\TransactionTypeResource;
use App\Http\Resources\Users\UserResource;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'reference' => $this->resource->reference,
            'issue_date' => $this->resource->issue_date,
            'issue_time' => $this->resource->issue_time,
            'issue_at' => $this->resource->issue_at,
            'due_date' => $this->resource->due_date,
            'observation' => $this->resource->observation,
            'base_amount' => $this->resource->base_amount,
            'tax_amount' => $this->resource->tax_amount,
            'base_tax_amount' => $this->resource->base_tax_amount,
            'discount_amount' => $this->resource->discount_amount,
            'other_charges_amount' => $this->resource->other_charges_amount,
            'global_discount_amount' => $this->resource->global_discount_amount,
            'total_amount' => $this->resource->total_amount,
            'transaction_type' => TransactionTypeResource::make($this->resource->transactionType),
            'document_type' => DocumentTypeResource::make($this->resource->documentType),
            'currency' => CurrencyResource::make($this->resource->currency),
            'acquirer' => AcquirerResource::make($this->resource->acquirer),
            'issuer' => IssuerResource::make($this->resource->issuer),
            'user' => UserResource::make($this->resource->user),
            'taxes' => InvoiceTaxResource::collection($this->resource->taxes),
            'items' => InvoiceItemResource::collection($this->resource->items),
        ];
    }
}
