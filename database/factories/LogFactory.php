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
            'morning_med' => fake()->optional(0.01)->boolean(),
            'afternoon_med' => fake()->optional(0.01)->boolean(),
            'night_med' => fake()->optional(0.01)->boolean(),
            'breakfast' => fake()->optional(0.01)->boolean(),
            'lunch' => fake()->optional(0.01)->boolean(),
            'dinner' => fake()->optional(0.01)->boolean(),
        ];
    }
}
