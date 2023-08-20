<?php

namespace App\Exceptions\Contracts;

use Exception;

class UnexpectedDocumentTypeCodeValue extends Exception
{
    public function __construct()
    {
        parent::__construct('Unexpected match value for document type code enum');
    }
}
