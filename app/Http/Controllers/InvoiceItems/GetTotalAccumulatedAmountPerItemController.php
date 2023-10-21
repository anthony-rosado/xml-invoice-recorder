<?php

namespace App\Http\Controllers\InvoiceItems;

use App\Http\Resources\InvoiceItems\TotalAccumulatedItemResource;
use App\Services\InvoiceItemService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetTotalAccumulatedAmountPerItemController
{
    public function __invoke(): AnonymousResourceCollection
    {
        $service = new InvoiceItemService();

        $itemList = $service->getTotalAccumulatedAmountPerItem();

        return TotalAccumulatedItemResource::collection($itemList);
    }
}
