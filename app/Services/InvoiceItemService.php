<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceItemTax;

class InvoiceItemService
{
    private InvoiceItem $invoiceItem;

    public function setInvoiceItem(InvoiceItem $invoiceItem): void
    {
        $this->invoiceItem = $invoiceItem;
    }

    public function getInvoiceItem(): InvoiceItem
    {
        return $this->invoiceItem;
    }

    public function create(array $attributes, Invoice $invoice): void
    {
        /** @var InvoiceItem $invoiceItem */
        $invoiceItem = InvoiceItem::query()->make($attributes);
        $invoiceItem->invoice()->associate($invoice);
        $invoiceItem->save();

        $this->setInvoiceItem($invoiceItem);
    }

    public function addTaxes(array $taxes): void
    {
        foreach ($taxes as $tax) {
            $taxModel = TaxService::findByCode($tax['code']);

            /** @var InvoiceItemTax $invoiceTax */
            $invoiceTax = InvoiceItemTax::query()->make(['amount' => $tax['amount']]);
            $invoiceTax->item()->associate($this->getInvoiceItem());
            $invoiceTax->tax()->associate($taxModel);
            $invoiceTax->save();
        }
    }
}
