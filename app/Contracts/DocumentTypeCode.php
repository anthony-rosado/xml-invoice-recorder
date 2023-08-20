<?php

namespace App\Contracts;

use App\Exceptions\Contracts\UnexpectedDocumentTypeCodeValue;

enum DocumentTypeCode: string
{
    case Bill = '01';

    /**
     * @throws UnexpectedDocumentTypeCodeValue
     */
    public static function fromCode(string $code): self
    {
        return match ($code) {
            '01' => self::Bill,
            default => throw new UnexpectedDocumentTypeCodeValue(),
        };
    }

    public function codeName(): string
    {
        return match ($this) {
            self::Bill => 'bill',
        };
    }
}
