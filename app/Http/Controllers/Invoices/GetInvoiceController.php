<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Resources\Invoices\InvoiceResource;
use App\Models\Invoice;

class GetInvoiceController
{
    public function __invoke(Invoice $invoice): InvoiceResource
    {
        $invoice->load([
            'transactionType',
            'documentType',
            'currency',
            'acquirer.identification',
            'issuer.identification',
            'user',
            'taxes',
            'items.taxes',
        ]);

        return InvoiceResource::make($invoice);
    }
}
