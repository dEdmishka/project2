<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\Staff;
use App\Models\StaffType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::factory()->create([
            'user_id' => 4,
        ]);

        Staff::factory()->count(15)->create()->each(function ($staff) {
            $staff->phoneNumbers()->createMany(
                collect(range(1, rand(1, 3)))->map(function () {
                    return ['phone_number' => fake()->numerify('0##-###-##-##')];
                })->toArray()
            );

            $socialPlatforms = ['facebook', 'instagram', 'linkedin', 'tiktok'];
            $staff->socialLinks()->createMany(
                collect($socialPlatforms)
                    ->random(rand(1, 3))
                    ->map(function ($platform) {
                        $url = "https://{$platform}.com/" . Str::slug(fake()->company);
                        return [
                            'url' => $url,
                            'platform' => detectPlatformFromUrl($url),
                        ];
                    })
                    ->toArray()
            );

            foreach (range(0, 6) as $day) {
                $isDayOff = $day === 6;
                $staff->workingHours()->create([
                    'day_of_week' => (string) $day,
                    'start_time' => $isDayOff ? null : '08:00:00',
                    'end_time' => $isDayOff ? null : '18:00:00',
                    'is_day_off' => $isDayOff,
                ]);
            }
        });
    }
}
