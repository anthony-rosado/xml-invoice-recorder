<?php

namespace Tests\Unit\Enums;

use App\Enums\TransactionTypeCode;
use App\Exceptions\Enums\UnexpectedTransactionTypeCodeValue;
use PHPUnit\Framework\TestCase;

class TransactionTypeCodeTest extends TestCase
{
    public function testThatEnumCanBeInstantiatedFromValidStringCode(): void
    {
        $transactionTypeCode = TransactionTypeCode::fromString('0101');

        $this->assertIsObject($transactionTypeCode);
        $this->assertInstanceOf(TransactionTypeCode::class, $transactionTypeCode);
        $this->assertTrue($transactionTypeCode === TransactionTypeCode::InternalSales);
    }

    public function testThatEnumCanNotBeInstantiatedFromInvalidStringCode(): void
    {
        $this->expectException(UnexpectedTransactionTypeCodeValue::class);

        TransactionTypeCode::fromString('9428');
    }

    public function testThatALabelCanBeObtainedFromEnumInstance()
    {
        $transactionTypeCodeLabel = TransactionTypeCode::Exportation->label();

        self::assertIsString($transactionTypeCodeLabel);
    }
}
