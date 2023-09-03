<?php

namespace Database\Factories;

use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->shuffleString(strtoupper($this->faker->word())),
            'description' => ucfirst($this->faker->words(3, true)),
            'quantity' => $this->faker->randomFloat(3, 0, 99999),
            'unit_value' => $this->faker->randomFloat(3, 0, 99999),
            'unit_price' => $this->faker->randomFloat(3, 0, 99999),
            'base_amount' => $this->faker->randomFloat(3, 0, 99999),
            'tax_amount' => $this->faker->randomFloat(3, 0, 99999),
            'discount_amount' => $this->faker->randomFloat(3, 0, 99999),
            'other_charges_amount' => $this->faker->randomFloat(3, 0, 99999),
            'total_amount' => $this->faker->randomFloat(3, 0, 99999),
        ];
    }
}
