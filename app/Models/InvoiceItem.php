<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InvoiceItem extends Model
{
    protected $fillable = [
        'code',
        'description',
        'quantity',
        'unit_value',
        'unit_price',
        'base_amount',
        'tax_amount',
        'discount_amount',
        'other_charges_amount',
        'total_amount',
    ];

    protected $attributes = [
        'quantity' => 1,
        'unit_value' => 0,
        'unit_price' => 0,
        'base_amount' => 0,
        'tax_amount' => 0,
        'discount_amount' => 0,
        'other_charges_amount' => 0,
        'total_amount' => 0,
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'unit_value' => 'decimal:3',
        'unit_price' => 'decimal:3',
        'base_amount' => 'decimal:3',
        'tax_amount' => 'decimal:3',
        'discount_amount' => 'decimal:3',
        'other_charges_amount' => 'decimal:3',
        'total_amount' => 'decimal:3',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function taxes(): BelongsToMany
    {
        return $this->belongsToMany(Tax::class, 'invoice_item_tax', 'item_id')
            ->using(InvoiceItemTax::class)
            ->withPivot(['percentage', 'amount']);
    }
}
