<?php

namespace App\Exceptions\Helpers;

use Exception;
use Throwable;

class CouldNotTransformInvoiceXmlToArrayException extends Exception
{
    public function __construct(Throwable $throwable)
    {
        parent::__construct('Could not transform invoice XML to array', 400, $throwable);
    }
}
