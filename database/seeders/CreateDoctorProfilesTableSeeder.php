<?php

namespace Database\Seeders;

use App\Models\DoctorProfile;
use Illuminate\Database\Seeder;

class CreateDoctorProfilesTableSeeder extends Seeder
{
    public function run(): void
    {
        DoctorProfile::factory()->count(3)->create();
    }
}
