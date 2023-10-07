<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Acquirer
 *
 * @property int $id
 * @property string $company_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Identification|null $identification
 */
class Acquirer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
    ];

    public function identification(): MorphOne
    {
        return $this->morphOne(Identification::class, 'identifiable');
    }
}
