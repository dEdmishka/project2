<?php

namespace Database\Seeders;

use App\Models\StaffType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Therapist', 'Nurse', 'Physiotherapist', 'Occupational Therapist', 'Speech Therapist', 'Psychologist', 'Psychiatrist', 'Technician', 'Support Staff'];

        foreach ($types as $type) {
            StaffType::create(['type' => $type]);
        }
    }
}
