<?php

namespace Database\Seeders;

use App\Models\Center;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Center::factory()->count(5)->create()->each(function ($center) {
            $center->phoneNumbers()->createMany(
                collect(range(1, rand(1, 3)))->map(function () {
                    return ['phone_number' => fake()->numerify('0##-###-##-##')];
                })->toArray()
            );

            $socialPlatforms = ['facebook', 'instagram', 'linkedin', 'tiktok'];
            $center->socialLinks()->createMany(
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
                $center->workingHours()->create([
                    'day_of_week' => (string) $day,
                    'start_time' => $isDayOff ? null : '08:00:00',
                    'end_time' => $isDayOff ? null : '18:00:00',
                    'is_day_off' => $isDayOff,
                ]);
            }
        });
    }
}
