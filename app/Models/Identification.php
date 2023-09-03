<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Identification
 *
 * @property int $id
 * @property int $type_id
 * @property string $value
 * @property string $identifiable_type
 * @property int $identifiable_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model $identifiable
 * @property-read IdentificationType $type
 */
class Identification extends Model
{
    use HasFactory;

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
