<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Patient;
use App\Models\Record;
use App\Models\Report;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = array (
            UserSeeder::class, 
            CenterSeeder::class, 
            DepartmentTypeSeeder::class, 
            StaffTypeSeeder::class, 
            RecordTypeSeeder::class,
            ReportTypeSeeder::class,
            DepartmentSeeder::class,
            PatientSeeder::class,
            StaffSeeder::class,
            ProcedureSeeder::class,
        );

        foreach ($seeders as $seeder)
        { 
           $this->call($seeder);
        }
    }
}
