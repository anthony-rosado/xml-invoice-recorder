<?php

namespace App\Contracts;

use App\Exceptions\Contracts\UnexpectedCurrencyCodeValue;

enum CurrencyCode: string
{
    case Pen = 'PEN';
    case Usd = 'USD';
    case Eur = 'EUR';

    /**
     * @throws UnexpectedCurrencyCodeValue
     */
    public static function fromCode(string $code): self
    {
        return match ($code) {
            'PEN' => self::Pen,
            'USD' => self::Usd,
            'EUR' => self::Eur,
            default => throw new UnexpectedCurrencyCodeValue(),
        };
    }

    public function codeName(): string
    {
        return match ($this) {
            self::Pen => 'peruvian_sol',
            self::Usd => 'american_dollar',
            self::Eur => 'euro',
        };
    }
}
