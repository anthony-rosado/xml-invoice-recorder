<?php

namespace Database\Factories;

use App\Models\Acquirer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Acquirer>
 */
class AcquirerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company() . ' ' . $this->faker->companySuffix(),
        ];
    }
}
