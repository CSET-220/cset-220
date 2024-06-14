<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Roster>
 */
class RosterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $doctor = User::where('role_id', 3)->get()->random();
        $supervisor = User::where('role_id', 2)->get()->random();
        $caregivers = User::where('role_id', 4)->get()->random(4);

        return [
            'doctor_id' => $doctor->id,
            'supervisor_id' => $supervisor->id,
            'caregiver1_id' => $caregivers[0]->id,
            'caregiver2_id' => $caregivers[1]->id,
            'caregiver3_id' => $caregivers[2]->id,
            'caregiver4_id' => $caregivers[3]->id,
        ];
    }
}
