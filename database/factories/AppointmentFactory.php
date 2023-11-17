<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Roster;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $meds = Prescription::all();

        return [
            'morning_med' => fake()->optional(0.4)->randomElement($meds->pluck('id')->all()),
            'afternoon_med' => fake()->optional(0.4)->randomElement($meds->pluck('id')->all()),
            'night_med' => fake()->optional(0.4)->randomElement($meds->pluck('id')->all()),
            'comments' => fake()->text(),
        ];
    }
}
