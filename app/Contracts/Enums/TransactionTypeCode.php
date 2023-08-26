<?php

namespace App\Contracts\Enums;

interface TransactionTypeCode extends Code
{
    public const INTERNAL_SALES = '0101';
    public const EXPORTATION = '0102';
    public const NOT_DOMICILED = '0103';
    public const INTERNAL_SALES_ADVANCES = '0104';
    public const ITINERANT_SALE = '0105';
    public const INVOICE_GUIDE = '0106';
    public const RICE_SALE = '0107';
    public const PERCEPTION_RECEIPT_INVOICE = '0108';
    public const INVOICE_SHIPPER_GUIDE = '0110';
}
