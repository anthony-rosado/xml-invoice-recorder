<?php

namespace App\Contracts\Enums;

interface IdentificationTypeCode extends Code
{
    public const NO_DOCUMENT = '0';
    public const DNI = '1';
    public const FOREIGNER_CARD = '4';
    public const RUC = '6';
    public const PASSPORT = '7';
}
