<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'admin',
            'last_name' => 'adminovich',
            'email' => 'admin@admin.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'first_name' => 'test',
            'last_name' => 'testovich',
            'email' => 'test@test.com',
            'role' => 'regular',
        ]);

        User::factory()->create([
            'first_name' => 'patient',
            'last_name' => 'patientovich',
            'email' => 'patient@patient.com',
            'role' => 'regular',
        ]);

        User::factory()->create([
            'first_name' => 'staff',
            'last_name' => 'staffovich',
            'email' => 'staff@staff.com',
            'role' => 'regular',
        ]);

        User::factory(10)->create();
    }
}
