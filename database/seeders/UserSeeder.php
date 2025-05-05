<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a student user
        User::create([
            'U_name' => 'Test Student',
            'U_Mail' => 'student@example.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);

        // Create an employee user
        User::create([
            'U_name' => 'Test Employee',
            'U_Mail' => 'employee@example.com',
            'password' => Hash::make('password123'),
            'role' => 'employee',
        ]);

        $this->command->info('Test users created successfully.');
    }
}
