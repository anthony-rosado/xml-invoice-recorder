<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Issuer
 *
 * @property int $id
 * @property string $company_name
 * @property string $trade_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Identification|null $identification
 */
class Issuer extends Model
{
    protected $fillable = [
        'company_name',
        'trade_name',
    ];

    protected $appends = [
        'identification_type_name',
        'identification_value',
    ];

    protected function identificationTypeName(): Attribute
    {
        return Attribute::make(
            fn () => $this->identification->type_name,
        );
    }

    protected function identificationValue(): Attribute
    {
        return Attribute::make(
            fn () => $this->identification->value,
        );
    }

    public function identification(): MorphOne
    {
        return $this->morphOne(Identification::class, 'identifiable');
    }
}
