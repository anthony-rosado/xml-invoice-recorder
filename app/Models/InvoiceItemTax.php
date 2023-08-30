<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\InvoiceItemTax
 *
 * @property int $item_id
 * @property int $tax_id
 * @property string $amount
 * @property-read InvoiceItem $item
 * @property-read Tax $tax
 */
class InvoiceItemTax extends Pivot
{
    public $timestamps = false;

    protected $attributes = [
        'amount' => 0,
    ];

    protected $casts = [
        'amount' => 'decimal:3',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(InvoiceItem::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }
}
