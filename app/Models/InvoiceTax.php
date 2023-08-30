<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\InvoiceTax
 *
 * @property int $invoice_id
 * @property int $tax_id
 * @property string $amount
 * @property-read Invoice $invoice
 * @property-read Tax $tax
 */
class InvoiceTax extends Pivot
{
    public $timestamps = false;

    protected $attributes = [
        'amount' => 0,
    ];

    protected $casts = [
        'amount' => 'decimal:3',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }
}
