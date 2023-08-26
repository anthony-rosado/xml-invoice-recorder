<?php

namespace App\Enums;

use App\Contracts\Enums\TransactionTypeCode as TransactionTypeCodeContract;
use App\Exceptions\Enums\UnexpectedTransactionTypeCodeValue;

enum TransactionTypeCode: string implements TransactionTypeCodeContract
{
    case InternalSales = self::INTERNAL_SALES;
    case Exportation = self::EXPORTATION;
    case NotDomiciled = self::NOT_DOMICILED;
    case InternalSalesAdvances = self::INTERNAL_SALES_ADVANCES;
    case ItinerantSale = self::ITINERANT_SALE;
    case InvoiceGuide = self::INVOICE_GUIDE;
    case RiceSale = self::RICE_SALE;
    case PerceptionReceiptInvoice = self::PERCEPTION_RECEIPT_INVOICE;
    case InvoiceShipperGuide = self::INVOICE_SHIPPER_GUIDE;

    /**
     * @throws UnexpectedTransactionTypeCodeValue
     */
    public static function fromString(string $code): self
    {
        return match ($code) {
            self::INTERNAL_SALES => self::InternalSales,
            self::EXPORTATION => self::Exportation,
            self::NOT_DOMICILED => self::NotDomiciled,
            self::INTERNAL_SALES_ADVANCES => self::InternalSalesAdvances,
            self::ITINERANT_SALE => self::ItinerantSale,
            self::INVOICE_GUIDE => self::InvoiceGuide,
            self::RICE_SALE => self::RiceSale,
            self::PERCEPTION_RECEIPT_INVOICE => self::PerceptionReceiptInvoice,
            self::INVOICE_SHIPPER_GUIDE => self::InvoiceShipperGuide,
            default => throw new UnexpectedTransactionTypeCodeValue(),
        };
    }

    public function label(): string
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
