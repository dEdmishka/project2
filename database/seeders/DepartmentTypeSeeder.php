<?php

namespace Database\Seeders;

use App\Models\DepartmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Cardiology', 'Radiology', 'Neurology', 'Oncology', 'Pediatrics', 'Orthopedics'];

        foreach ($types as $type) {
            DepartmentType::create(['type' => $type]);
        }
    }
}
