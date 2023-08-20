<?php

namespace App\Contracts;

use App\Exceptions\Contracts\UnexpectedTransactionTypeCodeValue;

enum TransactionTypeCode: string
{
    case InternalSales = '0101';
    case Exportation = '0102';
    case NotDomiciled = '0103';
    case InternalSalesAdvances = '0104';
    case ItinerantSale = '0105';
    case InvoiceGuide = '0106';
    case RiceSale = '0107';
    case PerceptionReceiptInvoice = '0108';
    case InvoiceShipperGuide = '0110';

    /**
     * @throws UnexpectedTransactionTypeCodeValue
     */
    public static function fromCode(string $code): self
    {
        return match ($code) {
            '0101' => self::InternalSales,
            '0102' => self::Exportation,
            '0103' => self::NotDomiciled,
            '0104' => self::InternalSalesAdvances,
            '0105' => self::ItinerantSale,
            '0106' => self::InvoiceGuide,
            '0107' => self::RiceSale,
            '0108' => self::PerceptionReceiptInvoice,
            '0110' => self::InvoiceShipperGuide,
            default => throw new UnexpectedTransactionTypeCodeValue(),
        };
    }

    public function codeName(): string
    {
        return match ($this) {
            self::InternalSales => 'internal_sales',
            self::Exportation => 'exportation',
            self::NotDomiciled => 'not_domiciled',
            self::InternalSalesAdvances => 'internal_sales_advances',
            self::ItinerantSale => 'itinerant_sale',
            self::InvoiceGuide => 'invoice_guide',
            self::RiceSale => 'rice_sale',
            self::PerceptionReceiptInvoice => 'perception_receipt_invoice',
            self::InvoiceShipperGuide => 'invoice_shipper_guide',
        };
    }
}
