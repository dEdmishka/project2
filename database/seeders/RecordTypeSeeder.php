<?php

namespace Database\Seeders;

use App\Models\RecordType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecordTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Medical Card', 'Treatment Plan', 'Presription', 'Session Log', 'Incident', 'Intake Summary', 'Discharge Summary', 'Billing', 'Medical Test'];

        foreach ($types as $type) {
            RecordType::create(['type' => $type]);
        }
    }
}
