<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Procedure>
 */
class ProcedureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $procedureNames = [
            'Physiotherapy',
            'Occupational Therapy',
            'Speech Therapy',
            'Cardiac',
            'Neurorehabilitation',
            'Orthopedic',
            'Pulmonary',
            'Pain Management',
            'Sports Injury',
            'Geriatric'
        ];

        return [
            'name' => fake()->randomElement($procedureNames),
            'description' => fake()->paragraph(),
            'cost' => fake()->randomFloat(2, 10, 1000),
            'duration' => fake()->numberBetween(1, 360),
            'is_active' => fake()->boolean(90),
        ];
    }
}
