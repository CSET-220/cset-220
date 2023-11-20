<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prescription>
 */
class PrescriptionFactory extends Factory
{
    public function definition(): array
    {
        $doses/*and mimosas*/= [5, 10, 15, 20, 25, 30, 40, 50, 60, 70 ,80, 90, 100];

        return [
            'medication_dosage' => fake()->randomElement($doses)
        ];
    }
}
