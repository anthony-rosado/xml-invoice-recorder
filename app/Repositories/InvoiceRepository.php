<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InvoiceRepository
{
    public function fetchTotalAccumulatedPerCurrency(): Collection
    {
        return DB::table('invoices as i')
            ->selectRaw('c.code as currency_code, sum(i.total_amount) as total_amount')
            ->join('currencies as c', 'c.id', '=', 'i.currency_id')
            ->groupBy('i.currency_id')
            ->get();
    }
}
