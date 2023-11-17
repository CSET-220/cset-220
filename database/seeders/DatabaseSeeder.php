<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Patient;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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


        // ----- Users -----
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
    }
}
