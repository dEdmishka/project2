<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\Department;
use App\Models\DepartmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $centers = Center::all();
        $types = DepartmentType::all();

        foreach ($centers as $center) {
            // Create 2–5 departments per center
            for ($i = 0; $i < rand(2, 5); $i++) {
                $type = $types->random();

                Department::create([
                    'center_id' => $center->id,
                    'department_type_id' => $type->id,
                    'name' => $type->type . ' Department',
                    'description' => fake()->sentence(),
                    'floor' => rand(1, 5),
                ]);
            }
        }
    }
}
