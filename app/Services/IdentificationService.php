<?php

namespace App\Services;

use App\Models\Identification;
use App\Models\IdentificationType;
use Illuminate\Database\Eloquent\Model;

class IdentificationService
{
    public function create(array $attributes, IdentificationType $type, Model $identifiable): void
    {
        /** @var Identification $identification */
        $identification = Identification::make($attributes);
        $identification->type()->associate($type);
        $identification->identifiable()->associate($identifiable);
        $identification->save();
    }
}
