<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::factory()->create([
            'user_id' => 3,
        ]);
        
        Patient::factory()->count(50)->create();
    }
}
