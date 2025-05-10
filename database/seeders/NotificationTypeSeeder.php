<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Reminder', 'Cancellation', 'Document', 'Message', 'Billing', 'Intake', 'Discharge'];

        foreach ($types as $type) {
            NotificationType::create(['type' => $type]);
        }
    }
}
