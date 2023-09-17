<?php

namespace Tests\Feature\Services;

use App\Enums\TransactionTypeCode;
use App\Models\TransactionType;
use App\Services\TransactionTypeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class TransactionTypeServiceTest extends TestCase
{
    public function testFindTransactionTypeWithValidCode(): void
    {
        $code = TransactionTypeCode::InternalSales;

        $this->assertDatabaseHas('transaction_types', ['code' => $code->value]);

        $transactionType = TransactionTypeService::findByCode($code->value);

        self::assertInstanceOf(TransactionType::class, $transactionType);
        self::assertSame($code->value, $transactionType->code);
    }

    public function testUnableToFindTransactionTypeWithInvalidCode(): void
    {
        $code = '9999';

        $this->assertDatabaseMissing('transaction_types', ['code' => $code]);

        $this->expectException(ModelNotFoundException::class);

        TransactionTypeService::findByCode($code);
    }
}
