<?php

namespace App\Services;

use App\DataTransferObjects\Invoices\InvoiceTotalAmount;
use App\Models\Acquirer;
use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceTax;
use App\Models\Issuer;
use App\Models\TransactionType;
use App\Models\User;
use App\Repositories\InvoiceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class InvoiceService
{
    private Invoice $invoice;

    public function setInvoice(Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    public static function checkByReferenceIfExists(string $series, int $correlativeNumber): bool
    {
        return Invoice::query()
            ->where('series', '=', $series)
            ->where('correlative_number', '=', $correlativeNumber)
            ->exists();
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

            /** @var InvoiceTax $invoiceTax */
            $invoiceTax = InvoiceTax::query()->make(['amount' => $tax['amount']]);
            $invoiceTax->invoice()->associate($this->getInvoice());
            $invoiceTax->tax()->associate($taxModel);
            $invoiceTax->save();
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

    public function getList(int $perPage = 15): LengthAwarePaginator
    {
        return Invoice::query()
            ->withCount(['items'])
            ->paginate($perPage);
    }

    public function getTotalAccumulatedPerCurrency(): Collection
    {
        $repository = new InvoiceRepository();

        $records = $repository->fetchTotalAccumulatedPerCurrency();

        return $records->map(fn ($record) => new InvoiceTotalAmount(
            $record->currency_code,
            $record->total_amount
        ));
    }

    public function delete(): void
    {
        $invoiceItems = $this->getInvoice()->items()->get();

        $invoiceItems->each(function (InvoiceItem $invoiceItem) {
            $invoiceItemService = new InvoiceItemService();
            $invoiceItemService->setInvoiceItem($invoiceItem);
            $invoiceItemService->delete();
        });

        $this->getInvoice()->taxes()->delete();
        $this->getInvoice()->delete();
    }
}
