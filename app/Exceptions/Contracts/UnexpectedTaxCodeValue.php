<?php

namespace App\Exceptions\Contracts;

class UnexpectedTaxCodeValue extends \Exception
{
    public function __construct()
    {
        parent::__construct('Unexpected match value for tax code enum');
    }
}
