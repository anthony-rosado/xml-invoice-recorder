<?php

namespace App\Exceptions\Enums;

use Exception;

class UnexpectedIdentificationTypeCodeValue extends Exception
{
    public function __construct()
    {
        parent::__construct('Unexpected match value for identification type code enum');
    }
}
