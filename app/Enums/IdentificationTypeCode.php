<?php

namespace App\Enums;

use App\Exceptions\Enums\UnexpectedIdentificationTypeCodeValue;

enum IdentificationTypeCode: string
{
    case NoDocument = '0';
    case Dni = '1';
    case ForeignerCard = '4';
    case Ruc = '6';
    case Passport = '7';

    /**
     * @throws UnexpectedIdentificationTypeCodeValue
     */
    public static function fromCode(string $code): self
    {
        return match ($code) {
            '0' => self::NoDocument,
            '1' => self::Dni,
            '4' => self::ForeignerCard,
            '6' => self::Ruc,
            '7' => self::Passport,
            default => throw new UnexpectedIdentificationTypeCodeValue(),
        };
    }

    public function codeName(): string
    {
        return match ($this) {
            self::NoDocument => 'no_document',
            self::Dni => 'dni',
            self::ForeignerCard => 'foreigner_card',
            self::Ruc => 'ruc',
            self::Passport => 'passport',
        };
    }
}
