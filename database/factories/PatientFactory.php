<?php

namespace Database\Factories;

use App\Models\Center;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $centers = Center::all();
        $genders = ['F', 'M'];

        $randomGender = $genders[array_rand($genders)];
        $center = $centers->random();

        return [
            'user_id' => User::factory()->create()->id,
            'center_id' => $center->id,
            'birth_date' => fake()->date('Y-m-d', '-18 years'),
            'gender' => $randomGender,
            'address' => fake()->address(),
            'status' => 'active',
        ];
    }
}
