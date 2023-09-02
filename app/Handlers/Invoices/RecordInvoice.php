<?php

namespace App\Handlers\Invoices;

use App\Exceptions\Handlers\Invoices\CouldNotRecordInvoice;
use App\Exceptions\Handlers\Invoices\InvoiceAlreadyRecorded;
use App\Exceptions\Helpers\CouldNotTransformInvoiceXmlToArrayException;
use App\Helpers\InvoiceXmlToArray;
use App\Mappers\InvoiceDataMapper;
use App\Models\Invoice;
use App\Models\User;
use App\Services\AcquirerService;
use App\Services\CurrencyService;
use App\Services\DocumentTypeService;
use App\Services\InvoiceService;
use App\Services\IssuerService;
use App\Services\TransactionTypeService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

readonly class RecordInvoice
{
    public function __construct(
        private TransactionTypeService $transactionTypeService,
        private DocumentTypeService $documentTypeService,
        private CurrencyService $currencyService,
        private IssuerService $issuerService,
        private AcquirerService $acquirerService,
        private InvoiceService $invoiceService
    ) {
    }

    /**
     * @throws CouldNotRecordInvoice
     * @throws CouldNotTransformInvoiceXmlToArrayException
     * @throws InvoiceAlreadyRecorded
     */
    public function handle(string $content, User $user): Invoice
    {
        $data = (new InvoiceXmlToArray($content))->transform();
        $mapper = new InvoiceDataMapper($data);

        $invoiceExists = $this->invoiceService->checkByReferenceIfExists(
            $mapper->getAttributes()['series'],
            $mapper->getAttributes()['correlative_number']
        );

        if ($invoiceExists) {
            throw new InvoiceAlreadyRecorded(
                $mapper->getAttributes()['series'],
                $mapper->getAttributes()['correlative_number']
            );
        }

        try {
            DB::beginTransaction();

            $transactionType = $this->transactionTypeService->findByCode($mapper->getTransactionTypeCode());
            $documentType = $this->documentTypeService->findByCode($mapper->getDocumentTypeCode());
            $currency = $this->currencyService->findByCode($mapper->getCurrencyCode());

            $this->issuerService->create(Arr::only($mapper->getIssuer(), ['company_name', 'trade_name']));
            $this->issuerService->addIdentification($mapper->getIssuer()['identification']);
            $issuer = $this->issuerService->getIssuer();

            $this->acquirerService->create(Arr::only($mapper->getAcquirer(), ['company_name']));
            $this->acquirerService->addIdentification($mapper->getAcquirer()['identification']);
            $acquirer = $this->acquirerService->getAcquirer();

            $this->invoiceService->create(
                $mapper->getAttributes(),
                $transactionType,
                $documentType,
                $currency,
                $issuer,
                $acquirer,
                $user
            );
            $this->invoiceService->addTaxes($mapper->getTaxes());
            $this->invoiceService->addItems($mapper->getItems());

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            throw new CouldNotRecordInvoice($exception);
        }

        return $this->invoiceService->getInvoice();
    }
}
