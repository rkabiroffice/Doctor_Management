<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CreateHeroSectionsTableSeeder::class,
            CreateAboutSectionsTableSeeder::class,
            CreateBiographiesTableSeeder::class,
            CreatePortfolioSectionsTableSeeder::class,
            CreateSettingsTableSeeder::class,
            CreateServicesTableSeeder::class,
            CreateEducationTableSeeder::class,
            CreateBlogsTableSeeder::class,
            CreateClinicsTableSeeder::class,
            CreateSchedulesTableSeeder::class,
            CreateReviewsTableSeeder::class,
            CreateAppointmentsTableSeeder::class,
            CreatePrescriptionsTableSeeder::class,
            CreatePrescriptionMedicinesTableSeeder::class,
            CreateRolesTableSeeder::class,
            CreateUsersTableSeeder::class,
        ]);
    }
}
