<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\Staff;
use App\Models\StaffType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $centers = Center::all();
        $genders = ['F', 'M'];
        $types = StaffType::all();

        foreach ($centers as $center) {
            $randomGender = $genders[array_rand($genders)];
            $type = $types->random();

            Staff::create([
                'user_id' => User::factory()->create()->id,
                'center_id' => $center->id,
                'birth_date' => fake()->date('Y-m-d', '-18 years'),
                'gender' => $randomGender,
                'address' => fake()->address(),
                'status' => 'active',
                'description' => fake()->paragraph(),
                'staff_type_id' => $type->id,
            ]);
        }
    }
}
