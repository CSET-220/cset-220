<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null
        ];
    }

    public function caregiver() {
        return $this->state(fn (array $attributes) => [
            'salary' => fake()->numberBetween(20000, 30000)
        ]);
    }

    public function doctor() {
        return $this->state(fn (array $attributes) => [
            'salary' => fake()->numberBetween(50000, 70000)
        ]);
    }

    public function supervisor() {
        return $this->state(fn (array $attributes) => [
            'salary' => fake()->numberBetween(70000, 100000)
        ]);
    }
}
