<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\IdentificationType
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class IdentificationType extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];
}
