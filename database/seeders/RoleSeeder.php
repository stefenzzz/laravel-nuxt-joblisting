<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'id' => 1,
                'name' => 'Administrator',
                'code' => 'admin',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Company',
                'code' => 'company',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Applicant',
                'code' => 'applicant',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            
        ]);
    }
}
