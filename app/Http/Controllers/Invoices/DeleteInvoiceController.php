<?php

namespace App\Http\Controllers\Invoices;

use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Response;

class DeleteInvoiceController
{
    public function __construct(
        private readonly InvoiceService $service
    ) {
    }

    public function __invoke(Invoice $invoice): Response
    {
        $this->service->setInvoice($invoice);
        $this->service->delete();

        return response()->noContent();
    }
}
