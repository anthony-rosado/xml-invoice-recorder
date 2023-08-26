<?php

namespace App\Enums;

use App\Contracts\Enums\IdentificationTypeCode as IdentificationTypeCodeContract;
use App\Exceptions\Enums\UnexpectedIdentificationTypeCodeValue;

enum IdentificationTypeCode: string implements IdentificationTypeCodeContract
{
    case NoDocument = self::NO_DOCUMENT;
    case Dni = self::DNI;
    case ForeignerCard = self::FOREIGNER_CARD;
    case Ruc = self::RUC;
    case Passport = self::PASSPORT;

    /**
     * @throws UnexpectedIdentificationTypeCodeValue
     */
    public static function fromString(string $code): self
    {
        return match ($code) {
            self::NO_DOCUMENT => self::NoDocument,
            self::DNI => self::Dni,
            self::FOREIGNER_CARD => self::ForeignerCard,
            self::RUC => self::Ruc,
            self::PASSPORT => self::Passport,
            default => throw new UnexpectedIdentificationTypeCodeValue(),
        };
    }

    public function label(): string
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
