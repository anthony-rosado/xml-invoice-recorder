<?php

namespace Tests\Feature\Repositories;

use Illuminate\Support\Collection;
use Tests\TestCase;

class InvoiceRepository extends TestCase
{
    public function testFetchTotalAccumulatedPerCurrency()
    {
        $repository = new \App\Repositories\InvoiceRepository();

        $resultSet = $repository->fetchTotalAccumulatedPerCurrency();

        self::assertInstanceOf(Collection::class, $resultSet);

        $resultSet->each(function (object $item) {
            self::assertIsString($item->currency_code);
            self::assertIsNumeric($item->total_amount);
        });
    }
}
