<?php

namespace App\Contracts\Enums;

interface Code
{
    public static function fromString(string $code): self;

    public function label(): string;
}
