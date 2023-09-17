<?php

namespace App\Exceptions\Handlers\Invoices;

use Exception;
use Throwable;

class CouldNotRecordInvoice extends Exception
{
    public function __construct(Throwable $throwable)
    {
        parent::__construct('Could not record invoice', 500, $throwable);
    }
}
