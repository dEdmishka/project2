<?php

namespace Database\Factories;

use App\Models\Center;
use App\Models\StaffType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
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
        $types = StaffType::all();

        $randomGender = $genders[array_rand($genders)];
        $type = $types->random();
        $center = $centers->random();

        return [
            'user_id' => User::factory()->create()->id,
            'birth_date' => fake()->date('Y-m-d', '-18 years'),
            'address' => fake()->address(),
            'status' => 'active',
            'description' => fake()->paragraph(),
            'center_id' => $center,
            'gender' => $randomGender,
            'staff_type_id' => $type
        ];
    }
}
