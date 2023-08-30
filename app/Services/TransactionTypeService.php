<?php

namespace App\Services;

use App\Models\TransactionType;

class TransactionTypeService
{
    public static function findByCode(string $code): TransactionType
    {
        /** @var TransactionType $transactionType */
        $transactionType = TransactionType::query()
            ->where('code', '=', $code)
            ->firstOrFail();

        return $transactionType;
    }
}
