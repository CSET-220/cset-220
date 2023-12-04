<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Appointment;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use App\Models\Roster;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Prescription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime, DatePeriod, DateInterval;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ----- Roles -----
        $roles = [
            ['id' => 1, 'role_title' => 'admin', 'access_level' => 1],
            ['id' => 2, 'role_title' => 'supervisor', 'access_level' => 1],
            ['id' => 3, 'role_title' => 'doctor', 'access_level' => 2],
            ['id' => 4, 'role_title' => 'caregiver', 'access_level' => 2],
            ['id' => 5, 'role_title' => 'patient', 'access_level' => 3],
            ['id' => 6, 'role_title' => 'family', 'access_level' => 3],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['id' => $role['id']], $role);
        }


        // ----- Users, Patients, and Employees -----
        User::factory(50)
            ->create()
            ->each(function ($user) {
                if ($user->role_id === 5) {
                    Patient::factory()
                    ->for($user)
                    ->create();
                }
                // Caregiver
                elseif ($user->role_id === 4) {
                    Employee::factory()
                    ->caregiver()
                    ->for($user)
                    ->create();
                }
                // Doctor
                elseif ($user->role_id === 3) {
                    Employee::factory()
                    ->doctor()
                    ->for($user)
                    ->create();
                }
                // Supervisor
                elseif ($user->role_id === 2) {
                    Employee::factory()
                    ->supervisor()
                    ->for($user)
                    ->create();
                }
            });


        // ----- Rosters -----
        $start = (new DateTime())->modify('-3 months');
        $end = (new DateTime())->modify('+1 month');
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end);

        foreach ($period as $day) {
            Roster::factory()->create(['date' => $day]);
        }


        // ----- Logs -----
        // each day, one log for each patient, match caregiver to group
        $patients = Patient::all();
        $rosters = Roster::all();

        foreach ($rosters as $roster) {
            if ($roster->date <= date('Y-m-d')) {
                foreach ($patients as $patient) {
                    $group = $patient->group;
                    $caregiver = null;
    
                    switch ($group) {
                        case 1:
                            $caregiver = $roster->caregiver1_id;
                            break;
                        case 2:
                            $caregiver = $roster->caregiver2_id;
                            break;
                        case 3:
                            $caregiver = $roster->caregiver3_id;
                            break;
                        case 4:
                            $caregiver = $roster->caregiver4_id;
                            break;
                    }
    
                    Log::factory()->create([
                        'patient_id' => $patient->id,
                        'caregiver_id' => $caregiver,
                        'date' => $roster->date,
                    ]);
                }
            }
            else {
                foreach ($patients as $patient) {
                    $group = $patient->group;
                    $caregiver = null;
    
                    switch ($group) {
                        case 1:
                            $caregiver = $roster->caregiver1_id;
                            break;
                        case 2:
                            $caregiver = $roster->caregiver2_id;
                            break;
                        case 3:
                            $caregiver = $roster->caregiver3_id;
                            break;
                        case 4:
                            $caregiver = $roster->caregiver4_id;
                            break;
                    }
    
                    Log::factory()->create([
                        'patient_id' => $patient->id,
                        'caregiver_id' => $caregiver,
                        'date' => $roster->date,
                        'morning_med' => null,
                        'afternoon_med' => null,
                        'night_med' => null,
                        'breakfast' => null,
                        'lunch' => null,
                        'dinner' => null,
                    ]);
                }
            }
        }


        // ----- Prescriptions -----
        $meds = array_map('ucfirst', fake()->words(10));

        for ($i = 0; $i < 50; $i++) {
            Prescription::factory()->create([
                'medication_name' => fake()->randomElement($meds)
            ]);
        }


        // ----- Appointments -----
        $patients = Patient::all();

        foreach ($patients as $patient) {
            $dates = collect();
            $numAppointments = rand(5, 15);

            for ($i = 0; $i < $numAppointments; $i++) {
                do {
                    $date = fake()->unique()->dateTimeBetween('-3 months', '+1 month')->setTime(0, 0);
                } 
                while ($dates->contains($date));

                $dates->push($date);

                // check to see if roster exists for the day
                $roster = Roster::whereDate('date', $date)->first();
                if ($roster === null) {
                    continue;
                }

                $doctor = Roster::whereDate('date', $date)->first()->doctor_id;

                // check to see if appointment is in the past
                if ($date <= date('Y-m-d')) {
                    Appointment::factory()->create([
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor,
                        'date' => $date,
                    ]);
                }
                else {
                    Appointment::factory()->create([
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor,
                        'date' => $date,
                        'morning_med' => null,
                        'afternoon_med' => null,
                        'night_med' => null,
                        'comments' => null,
                    ]);
                }

            }
        }
    }
}
