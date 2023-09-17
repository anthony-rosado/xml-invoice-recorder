<?php

namespace App\Http\Controllers\Invoices;

use App\Handlers\Invoices\RecordInvoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\UploadInvoiceRequest;
use App\Http\Resources\Invoices\InvoiceSmallResource;
use App\Http\Responses\ErrorResponse;
use Exception;
use Illuminate\Support\Facades\Auth;

class UploadInvoiceController extends Controller
{
    public function __construct(
        private readonly RecordInvoice $recordInvoice
    ) {
    }

    public function __invoke(UploadInvoiceRequest $request): InvoiceSmallResource|ErrorResponse
    {
        try {
            $invoice = $this->recordInvoice->perform($request->file('file')->getContent(), Auth::user());
        } catch (Exception $exception) {
            return ErrorResponse::fromException($exception);
        }

        $invoice->loadCount('items');

        return InvoiceSmallResource::make($invoice);
    }
}
