<?php

namespace App\Http\Controllers\Invoices;

use App\Handlers\Invoices\RecordInvoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\UploadInvoiceRequest;
use App\Http\Resources\Invoices\InvoiceSmallResource;
use App\Http\Responses\ErrorResponse;
use App\Models\User;
use App\Notifications\Invoices\InvoiceSummary;
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
        /** @var User $user */
        $user = Auth::user();

        try {
            $invoice = $this->recordInvoice->perform($request->file('file')->getContent(), $user);
        } catch (Exception $exception) {
            return ErrorResponse::fromException($exception);
        }

        $user->notify(new InvoiceSummary($invoice));

        $invoice->loadCount('items');

        return InvoiceSmallResource::make($invoice);
    }
}
