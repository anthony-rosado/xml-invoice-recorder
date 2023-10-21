<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InvoiceItemRepository
{
    public function fetchTotalAccumulatedAmountPerItem(): Collection
    {
        return DB::table('invoice_items as ii')
            ->selectRaw('ii.code, c.code as currency_code, sum(ii.total_amount) as total_amount')
            ->join('invoices as i', 'i.id', '=', 'ii.invoice_id')
            ->join('currencies as c', 'c.id', '=', 'i.currency_id')
            ->groupBy(['ii.code', 'i.currency_id'])
            ->orderBy('ii.code')
            ->get();
    }
}
