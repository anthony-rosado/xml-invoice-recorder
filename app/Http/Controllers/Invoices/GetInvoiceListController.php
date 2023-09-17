<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\GetInvoiceListRequest;
use App\Http\Resources\Invoices\InvoiceSmallResource;
use App\Services\InvoiceService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetInvoiceListController extends Controller
{
    public function __construct(
        private readonly InvoiceService $service
    ) {
    }

    public function __invoke(GetInvoiceListRequest $request): AnonymousResourceCollection
    {
        $invoices = $this->service->getList($request->get('per_page', 10));

        return InvoiceSmallResource::collection($invoices);
    }
}
