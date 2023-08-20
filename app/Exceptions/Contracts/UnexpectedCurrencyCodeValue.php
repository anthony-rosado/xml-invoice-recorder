<?php

namespace App\Exceptions\Contracts;

use Exception;

class UnexpectedCurrencyCodeValue extends Exception
{
    public function __construct()
    {
        parent::__construct('Unexpected match value for currency code enum');
    }
}
