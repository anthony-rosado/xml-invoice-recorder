<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'series',
        'correlative_number',
        'issue_date',
        'issue_time',
        'due_date',
        'observation',
        'base_amount',
        'tax_amount',
        'base_tax_amount',
        'discount_amount',
        'other_charges_amount',
        'global_discount_amount',
        'total_amount',
    ];

    protected $attributes = [
        'base_amount' => 0,
        'tax_amount' => 0,
        'base_tax_amount' => 0,
        'global_discount_amount' => 0,
        'discount_amount' => 0,
        'other_charges_amount' => 0,
        'total_amount' => 0,
    ];

    protected $appends = [
        'reference',
        'issue_at',
    ];

    protected $casts = [
        'correlative_number' => 'integer',
        'base_amount' => 'decimal:3',
        'tax_amount' => 'decimal:3',
        'base_tax_amount' => 'decimal:3',
        'global_discount_amount' => 'decimal:3',
        'discount_amount' => 'decimal:3',
        'other_charges_amount' => 'decimal:3',
        'total_amount' => 'decimal:3',
    ];

    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Issuer::class);
    }

    public function acquirer(): BelongsTo
    {
        return $this->belongsTo(Acquirer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function taxes(): BelongsToMany
    {
        return $this->belongsToMany(Tax::class)
            ->using(InvoiceTax::class)
            ->withPivot(['amount']);
    }

    protected function reference(): Attribute
    {
        return Attribute::make(
            fn () => $this->series . '-' . $this->correlative_number,
        );
    }

    protected function issueAt(): Attribute
    {
        return Attribute::make(
            fn () => $this->issue_date . ' ' . $this->issue_time,
        );
    }
}
