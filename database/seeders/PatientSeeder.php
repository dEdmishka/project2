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
        $centers = Center::all();
        $genders = ['F', 'M'];

        foreach ($centers as $center) {
            $randomGender = $genders[array_rand($genders)];

            Patient::create([
                'user_id' => User::factory()->create()->id,
                'center_id' => $center->id,
                'birth_date' => fake()->date('Y-m-d', '-18 years'),
                'gender' => $randomGender,
                'address' => fake()->address(),
                'status' => 'active',
            ]);
        }
    }
}
