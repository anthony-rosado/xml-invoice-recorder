<?php

namespace App\Services;

use App\Models\Acquirer;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\Invoice;
use App\Models\Issuer;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Support\Arr;

class InvoiceService
{
    private Invoice $invoice;

    public function setInvoice(Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function create(
        array $attributes,
        TransactionType $transactionType,
        DocumentType $documentType,
        Currency $currency,
        Issuer $issuer,
        Acquirer $acquirer,
        User $user
    ): void {
        /** @var Invoice $invoice */
        $invoice = Invoice::query()->make($attributes);
        $invoice->transactionType()->associate($transactionType);
        $invoice->documentType()->associate($documentType);
        $invoice->currency()->associate($currency);
        $invoice->issuer()->associate($issuer);
        $invoice->acquirer()->associate($acquirer);
        $invoice->user()->associate($user);
        $invoice->save();

        $this->setInvoice($invoice);
    }

    public function addTaxes(array $taxes): void
    {
        foreach ($taxes as $tax) {
            $taxModel = TaxService::findByCode($tax['code']);

            $invoiceTaxService = new InvoiceTaxService();
            $invoiceTaxService->create(['amount' => $tax['amount']], $this->getInvoice(), $taxModel);
        }
    }

    public function addItems(array $items): void
    {
        foreach ($items as $item) {
            $invoiceItemService = new InvoiceItemService();
            $invoiceItemService->create(
                Arr::only(
                    $item,
                    [
                        'code',
                        'description',
                        'quantity',
                        'unit_value',
                        'unit_price',
                        'base_amount',
                        'tax_amount',
                        'discount_amount',
                        'other_charges_amount',
                        'total_amount',
                    ]
                ),
                $this->getInvoice()
            );
            $invoiceItemService->addTaxes($item['taxes']);
        }
    }
}
