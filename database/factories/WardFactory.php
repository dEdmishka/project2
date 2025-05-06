<?php

namespace Database\Factories;

use App\Models\Center;
use App\Models\Department;
use App\Models\Procedure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ward>
 */
class WardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $department = Department::with('center')->inRandomOrder()->first();

        static $wardNumbersByCenter = [];

        $centerId = $department->center_id;

        do {
            $wardNumber = fake()->numberBetween(1, 100);
        } while (
            isset($wardNumbersByCenter[$centerId]) &&
            in_array($wardNumber, $wardNumbersByCenter[$centerId])
        );

        $wardNumbersByCenter[$centerId][] = $wardNumber;
        $randomProcedure = Procedure::inRandomOrder()->first();

        return [
            'department_id' => $department->id,
            'procedure_id' => $randomProcedure->id,
            'name' => $randomProcedure->name . " Ward",
            'description' => fake()->sentence(),
            'capacity' => fake()->numberBetween(1, 5),
            'ward_number' => $wardNumber,
        ];
    }
}
