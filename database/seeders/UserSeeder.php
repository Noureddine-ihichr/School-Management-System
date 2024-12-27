<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create a default admin account
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), // Default password
            'role' => 'admin', // Ensure role field exists in your migration
        ]);
        User::create([
            'name' => 'Student User',
            'email' => 'student@gmail.com',
            'password' => Hash::make('student1'), // Default password
            'role' => 'student', // Ensure role field exists in your migration
        ]);
    }
}
