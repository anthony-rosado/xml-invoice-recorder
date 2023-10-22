<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Resources\Invoices\InvoiceTotalAmountResource;
use App\Services\InvoiceService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetTotalAccumulatedPerCurrencyController
{
    public function __construct(
        private readonly InvoiceService $service
    ) {
    }

    public function __invoke(): AnonymousResourceCollection
    {
        $amounts = $this->service->getTotalAccumulatedPerCurrency();

        return InvoiceTotalAmountResource::collection($amounts);
    }
}
