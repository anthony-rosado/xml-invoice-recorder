<?php

namespace App\Exceptions\Enums;

use Exception;

class UnexpectedDocumentTypeCodeValue extends Exception
{
    public function __construct()
    {
        parent::__construct('Unexpected match value for document type code enum');
    }
}
