<?php

namespace App\Enums;

use App\Contracts\Enums\DocumentTypeCode as DocumentTypeCodeContract;
use App\Exceptions\Enums\UnexpectedDocumentTypeCodeValue;

enum DocumentTypeCode: string implements DocumentTypeCodeContract
{
    case Bill = self::BILL;

    /**
     * @throws UnexpectedDocumentTypeCodeValue
     */
    public static function fromString(string $code): self
    {
        return match ($code) {
            self::BILL => self::Bill,
            default => throw new UnexpectedDocumentTypeCodeValue(),
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Bill => 'bill',
        };
    }
}
