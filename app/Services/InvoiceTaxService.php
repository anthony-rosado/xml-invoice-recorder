<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceTax;
use App\Models\Tax;

class InvoiceTaxService
{
    private InvoiceTax $invoiceTax;

    public function setInvoiceTax(InvoiceTax $invoiceTax): void
    {
        $this->invoiceTax = $invoiceTax;
    }

    public function getInvoiceTax(): InvoiceTax
    {
        return $this->invoiceTax;
    }

    public function create(array $attributes, Invoice $invoice, Tax $tax): void
    {
        /** @var InvoiceTax $invoiceTax */
        $invoiceTax = InvoiceTax::query()->make($attributes);
        $invoiceTax->invoice()->associate($invoice);
        $invoiceTax->tax()->associate($tax);
        $invoiceTax->save();

        $this->setInvoiceTax($invoiceTax);
    }
}
