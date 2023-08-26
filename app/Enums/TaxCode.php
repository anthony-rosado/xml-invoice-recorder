<?php

namespace App\Enums;

use App\Exceptions\Enums\UnexpectedTaxCodeValue;

enum TaxCode: string
{
    case Igv = '1000';
    case Isc = '2000';
    case Free = '9996';
    case Exonerated = '9997';
    case Unaffected = '9998';
    case Other = '9999';

    /**
     * @throws UnexpectedTaxCodeValue
     */
    public static function fromCode(string $code): self
    {
        return match ($code) {
            '1000' => self::Igv,
            '2000' => self::Isc,
            '9996' => self::Free,
            '9997' => self::Exonerated,
            '9998' => self::Unaffected,
            '9999' => self::Other,
            default => throw new UnexpectedTaxCodeValue(),
        };
    }

    public function codeName(): string
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
