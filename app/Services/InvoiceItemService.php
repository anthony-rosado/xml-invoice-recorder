<?php

namespace App\Services;

use App\DataTransferObjects\InvoiceItems\ItemTotalAmount;
use App\DataTransferObjects\InvoiceItems\TotalAccumulatedPerItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceItemTax;
use App\Repositories\InvoiceItemRepository;
use Illuminate\Support\Collection;

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

    public function getTotalAccumulatedAmountPerItem()
    {
        $repository = new InvoiceItemRepository();
        $records = $repository->fetchTotalAccumulatedAmountPerItem();

        return $records->groupBy('code')
            ->map(function (Collection $records) {
                $amounts = $records
                    ->map(function ($record) {
                        return new ItemTotalAmount(
                            $record->currency_code,
                            $record->total_amount
                        );
                    })
                    ->toArray();

                return new TotalAccumulatedPerItem(
                    $records->first()->code,
                    $amounts
                );
            })
            ->values();
    }

    public function delete(): void
    {
        $this->getInvoiceItem()->taxes()->delete();
        $this->getInvoiceItem()->delete();
    }
}
