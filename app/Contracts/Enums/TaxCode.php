<?php

namespace App\Contracts\Enums;

interface TaxCode extends Code
{
    public const IGV = '1000';
    public const ISC = '2000';
    public const FREE = '9996';
    public const EXONERATED = '9997';
    public const UNAFFECTED = '9998';
    public const OTHER = '9999';
}
