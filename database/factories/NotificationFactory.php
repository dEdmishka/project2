<?php

namespace Database\Factories;

use App\Models\NotificationType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $recipient = User::inRandomOrder()->first();
        $sender = User::inRandomOrder()->where('id', '!=', $recipient->id)->first();
        $notificationType = NotificationType::inRandomOrder()->first();

        return [
            'content' => fake()->sentence(),
            'recipient_id' => $recipient->id,
            'sender_id' => $sender->id,
            'status' => fake()->randomElement(['pending', 'read']),
            'notification_type_id' => $notificationType->id,
        ];
    }
}
