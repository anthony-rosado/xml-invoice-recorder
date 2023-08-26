<?php

namespace App\Exceptions\Enums;

use Exception;

class UnexpectedTransactionTypeCodeValue extends Exception
{
    public function __construct()
    {
        parent::__construct('Unexpected match value for transaction type code enum');
    }
}
