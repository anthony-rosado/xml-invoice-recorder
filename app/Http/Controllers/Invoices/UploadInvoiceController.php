<?php

namespace App\Http\Controllers\Invoices;

use App\Exceptions\Helpers\CouldNotTransformInvoiceXmlToArrayException;
use App\Helpers\InvoiceXmlToArray;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\UploadInvoiceRequest;
use App\Http\Resources\Invoices\InvoiceSmallResource;
use App\Http\Responses\ErrorResponse;
use App\Services\AcquirerService;
use App\Services\CurrencyService;
use App\Services\DocumentTypeService;
use App\Services\InvoiceService;
use App\Services\IssuerService;
use App\Services\TransactionTypeService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UploadInvoiceController extends Controller
{
    public function __invoke(UploadInvoiceRequest $request): InvoiceSmallResource|ErrorResponse
    {
        try {
            $data = (new InvoiceXmlToArray($request->file('file')->getContent()))->transform();
        } catch (CouldNotTransformInvoiceXmlToArrayException $exception) {
            return new ErrorResponse($exception->getMessage(), $exception->getPrevious()->getMessage());
        }

        $issuerService = new IssuerService();
        $issuerService->create(Arr::only($data['issuer'], ['company_name', 'trade_name']));
        $issuerService->addIdentification($data['issuer']['identification']);
        $issuer = $issuerService->getIssuer();

        $acquirerService = new AcquirerService();
        $acquirerService->create(Arr::only($data['acquirer'], ['company_name']));
        $acquirerService->addIdentification($data['acquirer']['identification']);
        $acquirer = $acquirerService->getAcquirer();

        $transactionType = TransactionTypeService::findByCode($data['transaction_type_code']);
        $documentType = DocumentTypeService::findByCode($data['document_type_code']);
        $currency = CurrencyService::findByCode($data['currency_code']);

        $invoiceService = new InvoiceService();
        $invoiceService->create(
            Arr::only(
                $data,
                [
                    'series',
                    'correlative_number',
                    'issue_date',
                    'issue_time',
                    'due_date',
                    'observation',
                    'base_amount',
                    'tax_amount',
                    'discount_amount',
                    'other_charges_amount',
                    'total_amount',
                ]
            ),
            $transactionType,
            $documentType,
            $currency,
            $issuer,
            $acquirer,
            Auth::user()
        );
        $invoiceService->addTaxes($data['taxes']);
        $invoiceService->addItems($data['items']);

        $invoice = $invoiceService->getInvoice()->loadCount('items');

        return InvoiceSmallResource::make($invoice);
    }
}
