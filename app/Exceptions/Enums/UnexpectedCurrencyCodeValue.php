<?php

namespace App\Exceptions\Enums;

use Exception;

class UnexpectedCurrencyCodeValue extends Exception
{
    public function __construct()
    {
        parent::__construct('Unexpected match value for currency code enum');
    }
}
