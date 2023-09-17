<?php

namespace App\Exceptions\Mappers;

use Exception;
use Throwable;

class UnableToGetElementFromData extends Exception
{
    public function __construct(string $key, ?Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Unable to get key [%s] from data', $key),
            500,
            $previous
        );
    }
}
