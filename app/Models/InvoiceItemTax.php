<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class InvoiceItemTax extends Pivot
{
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
