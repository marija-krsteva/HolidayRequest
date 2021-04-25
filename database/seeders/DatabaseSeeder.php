<?php

namespace Database\Seeders;

use App\Models\HolidayRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Get all roles
        $roles = User::getRoles();

        // Create an admin user
        User::factory()
            ->count(1)
            ->create([
                'role' => $roles['admin'],
                'email' => 'admin@admin.com'
            ]);

        // Create managers and employees
        User::factory()
            ->count(5)
            ->hasEmployees(3)
            ->create([
                'role' => $roles['manager']
            ]);

        // Create holiday requests for all the employees
        $employees = User::where('role', $roles['employee'])->get();
        foreach ($employees as $employee) {
            HolidayRequest::factory()
                ->count(10)
                ->create([
                    'firstname' => $employee->firstname,
                    'lastname' => $employee->lastname,
                    'phone_number' => $employee->phone_number,
                    'email' => $employee->email,
                    'user_id' => $employee->id,
                ]);
        }


    }
}
