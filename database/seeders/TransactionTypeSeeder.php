<?php

namespace Database\Seeders;

use App\Contracts\TransactionTypeCode;
use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactionTypes = [
            [
                'code' => TransactionTypeCode::InternalSales->value,
                'name' => __('transaction_types.code_names.internal_sales', [], 'es'),
            ],
            [
                'code' => TransactionTypeCode::Exportation->value,
                'name' => __('transaction_types.code_names.exportation', [], 'es'),
            ],
            [
                'code' => TransactionTypeCode::NotDomiciled->value,
                'name' => __('transaction_types.code_names.not_domiciled', [], 'es'),
            ],
            [
                'code' => TransactionTypeCode::InternalSalesAdvances->value,
                'name' => __('transaction_types.code_names.internal_sales_advances', [], 'es'),
            ],
            [
                'code' => TransactionTypeCode::ItinerantSale->value,
                'name' => __('transaction_types.code_names.itinerant_sale', [], 'es'),
            ],
            [
                'code' => TransactionTypeCode::InvoiceGuide->value,
                'name' => __('transaction_types.code_names.invoice_guide', [], 'es'),
            ],
            [
                'code' => TransactionTypeCode::RiceSale->value,
                'name' => __('transaction_types.code_names.rice_sale', [], 'es'),
            ],
            [
                'code' => TransactionTypeCode::PerceptionReceiptInvoice->value,
                'name' => __('transaction_types.code_names.perception_receipt_invoice', [], 'es'),
            ],
            [
                'code' => TransactionTypeCode::InvoiceShipperGuide->value,
                'name' => __('transaction_types.code_names.invoice_shipper_guide', [], 'es'),
            ],
        ];

        foreach ($transactionTypes as $transactionType) {
            TransactionType::query()->create($transactionType);
        }
    }
}
