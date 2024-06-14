<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'morning_med' => fake()->boolean(99),
            'afternoon_med' => fake()->boolean(99),   
            'night_med' => fake()->boolean(99),
            'breakfast' => fake()->boolean(99),
            'lunch' => fake()->boolean(99),
            'dinner' => fake()->boolean(99),
        ];
    }
}
