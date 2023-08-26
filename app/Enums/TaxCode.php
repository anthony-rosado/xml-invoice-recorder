<?php

namespace App\Enums;

use App\Contracts\Enums\TaxCode as TaxCodeContract;
use App\Exceptions\Enums\UnexpectedTaxCodeValue;

enum TaxCode: string implements TaxCodeContract
{
    case Igv = self::IGV;
    case Isc = self::ISC;
    case Free = self::FREE;
    case Exonerated = self::EXONERATED;
    case Unaffected = self::UNAFFECTED;
    case Other = self::OTHER;

    /**
     * @throws UnexpectedTaxCodeValue
     */
    public static function fromString(string $code): self
    {
        return match ($code) {
            self::IGV => self::Igv,
            self::ISC => self::Isc,
            self::FREE => self::Free,
            self::EXONERATED => self::Exonerated,
            self::UNAFFECTED => self::Unaffected,
            self::OTHER => self::Other,
            default => throw new UnexpectedTaxCodeValue(),
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Igv => 'igv',
            self::Isc => 'isc',
            self::Free => 'free',
            self::Exonerated => 'exonerated',
            self::Unaffected => 'unaffected',
            self::Other => 'other',
        };
    }
}
