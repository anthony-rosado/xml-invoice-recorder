<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Identification extends Model
{
    protected $fillable = [
        'value',
    ];

    protected $appends = [
        'type_name',
    ];

    protected function typeName(): Attribute
    {
        return Attribute::make(
            fn () => $this->type->name,
        );
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(IdentificationType::class);
    }

    public function identifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
