<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $patientIds = User::where('role_id', 5)->pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement($patientIds),
            'family_code' => fake()->unique()->sentence(3),
            'emergency_contact' => fake()->phoneNumber(),
            'contact_relation' => fake()->word(),
            'group' => fake()->numberBetween(1, 4),
            'admission_date' => fake()->dateTimeBetween('-10 years', 'now'),
            'last_paid_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'balance' => fake()->randomFloat(2, 0, 1000),
        ];
    }
}
