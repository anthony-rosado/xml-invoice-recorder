<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\InvoiceItem
 *
 * @property int $id
 * @property int $invoice_id
 * @property string $code
 * @property string $description
 * @property string $quantity
 * @property string $unit_value
 * @property string $unit_price
 * @property string $base_amount
 * @property string $tax_amount
 * @property string $discount_amount
 * @property string $other_charges_amount
 * @property string $total_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Invoice $invoice
 * @property-read Collection<int, Tax> $taxes
 * @property-read int|null $taxes_count
 */
class InvoiceItem extends Model
{
    use HasFactory;

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
            ->withPivot(['amount']);
    }
}
