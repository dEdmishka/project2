<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\RecordType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $patient = Patient::inRandomOrder()->first();

        // // Randomly select Intake Summary or Medical Card
        // $recordTypeName = $this->faker->randomElement(['Intake Summary', 'Medical Card']);
        // $recordType = RecordType::firstOrCreate(['name' => $recordTypeName]);

        // return [
        //     'recordable_type' => Patient::class,
        //     'recordable_id' => $patient->id,
        //     'record_type_id' => $recordType->id,
        //     'content' => $this->faker->paragraphs(3, true),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ];

        return [];
    }
}
