<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'series' => $this->generateSeries(),
            'correlative_number' => $this->faker->randomNumber(4),
            'issue_date' => $this->faker->date(),
            'issue_time' => $this->faker->time(),
            'due_date' => $this->faker->date,
            'observation' => $this->faker->paragraph(2),
            'base_amount' => $this->faker->randomFloat(3, 0, 99999),
            'tax_amount' => $this->faker->randomFloat(3, 0, 99999),
            'discount_amount' => $this->faker->randomFloat(3, 0, 99999),
            'other_charges_amount' => $this->faker->randomFloat(3, 0, 99999),
            'total_amount' => $this->faker->randomFloat(3, 0, 99999),
        ];
    }

    public function generateSeries(): string
    {
        return strtoupper($this->faker->randomLetter()) .
            str_pad($this->faker->randomDigitNotZero(), 3, '0', STR_PAD_LEFT);
    }
}
