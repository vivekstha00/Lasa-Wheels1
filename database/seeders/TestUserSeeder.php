<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Test User',
            'email' => 'bs2288175@gmail.com',
            'password' => Hash::make('password123'),
            'phone' => '1234567890',
            'age' => 25,
            'role' => 'user',
            'address' => 'Test Address',
            'driver_license' => 'DL123456',
        ]);
    }
}
