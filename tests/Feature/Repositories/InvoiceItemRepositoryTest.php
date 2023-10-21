<?php

namespace Feature\Repositories;

use App\Repositories\InvoiceItemRepository;
use Illuminate\Support\Collection;
use Tests\TestCase;

class InvoiceItemRepositoryTest extends TestCase
{
    public function testFetchTotalAccumulatedAmountPerItemReturnType()
    {
        $repository = new InvoiceItemRepository();

        $resultSet = $repository->fetchTotalAccumulatedAmountPerItem();

        self::assertInstanceOf(Collection::class, $resultSet);

        $resultSet->each(function ($item) {
            self::assertIsString($item->code);
            self::assertIsString($item->currency_code);
            self::assertIsNumeric($item->total_amount);
        });
    }
}
