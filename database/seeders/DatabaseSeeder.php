<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'phone' => '081234567890',
            'birth_date' => '2000-01-01',
            'address' => 'Jl. Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            
        ]);

        // Create some sample staff members
        User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'phone' => '081234567891',
            'birth_date' => '2000-01-01',
            'address' => 'Jl. Staff',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);
    }
}
