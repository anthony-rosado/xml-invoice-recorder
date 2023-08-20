<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Identification extends Model
{
    protected $fillable = [
        'value',
    ];

    protected $appends = [
        'type_code',
    ];

    protected function typeCode(): Attribute
    {
        return Attribute::make(
            fn () => $this->type->code,
        );
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(IdentificationType::class);
    }
}
