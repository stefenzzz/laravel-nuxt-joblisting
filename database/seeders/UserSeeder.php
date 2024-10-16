<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
           [
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 1,
            'email_verified_at' => now(),
           ],
           [
            'name' => 'corporation',
            'email' => 'company@corporate.com',
            'password' => Hash::make('password123'),
            'role_id' => 2,
            'email_verified_at' => now(),
           ],
           [
            'name' => 'john doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 3,
            'email_verified_at' => now(),
           ],
        ]);
    }
}
