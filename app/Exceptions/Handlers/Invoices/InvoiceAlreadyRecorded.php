<?php

namespace App\Exceptions\Handlers\Invoices;

use Exception;

class InvoiceAlreadyRecorded extends Exception
{
    public function __construct(string $series, int $correlativeNumber)
    {
        parent::__construct(
            sprintf('Invoice (%s-%s) already recorded', $series, $correlativeNumber),
            400
        );
    }
}
