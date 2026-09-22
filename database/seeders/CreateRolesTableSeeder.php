<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class CreateRolesTableSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(
            ['name' => 'Doctor'],
            [
                'permissions' => ['manage_profile', 'manage_sections', 'manage_services', 'manage_education', 'manage_blogs', 'manage_clinics', 'manage_schedules', 'manage_reviews', 'manage_appointments', 'manage_prescriptions', 'manage_medicines', 'manage_roles', 'manage_settings'],
                'description' => 'Full administrative access for the clinic owner.',
            ]
        );

        Role::updateOrCreate(
            ['name' => 'Receptionist'],
            [
                'permissions' => ['manage_appointments', 'view_profile', 'view_appointments'],
                'description' => 'Can manage bookings and patient scheduling.',
            ]
        );

        Role::updateOrCreate(
            ['name' => 'Assistant'],
            [
                'permissions' => ['view_profile', 'view_appointments', 'manage_reviews', 'manage_blogs'],
                'description' => 'Supports operations and content updates.',
            ]
        );
    }
}
