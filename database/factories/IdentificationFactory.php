<?php

namespace Database\Factories;

use App\Models\Identification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Identification>
 */
class IdentificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => $this->faker->randomNumber(),
        ];
    }
}
