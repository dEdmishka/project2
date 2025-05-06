<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Center;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\Ward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $center = Center::inRandomOrder()->first();

        $patient = Patient::where('center_id', $center->id)->inRandomOrder()->first();
        $ward = Ward::whereHas('department', fn($q) => $q->where('center_id', $center->id))->inRandomOrder()->first();

        return [
            'patient_id' => $patient->id,
            'ward_id' => $ward->id,
            'time' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => 'active',
            'notes' => fake()->paragraph(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Appointment $appointment) {
            $centerId = $appointment->patient->center_id;

            $staffIds = Staff::where('center_id', $centerId)
                ->inRandomOrder()
                ->take(rand(1, 3))
                ->pluck('id');

            $appointment->staff()->attach($staffIds);
        });
    }
}
