<?php

namespace App\Enums;

use App\Contracts\Enums\CurrencyCode as CurrencyCodeContract;
use App\Exceptions\Enums\UnexpectedCurrencyCodeValue;

enum CurrencyCode: string implements CurrencyCodeContract
{
    case Pen = self::PEN;
    case Usd = self::USD;
    case Eur = self::EUR;

    /**
     * @throws UnexpectedCurrencyCodeValue
     */
    public static function fromString(string $code): self
    {
        return match ($code) {
            self::PEN => self::Pen,
            self::USD => self::Usd,
            self::EUR => self::Eur,
            default => throw new UnexpectedCurrencyCodeValue(),
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Pen => 'peruvian_sol',
            self::Usd => 'american_dollar',
            self::Eur => 'euro',
        };
    }
}
