<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use Illuminate\Database\Seeder;

class CreatePrescriptionMedicinesTableSeeder extends Seeder
{
    public function run(): void
    {
        $prescriptions = Prescription::query()->get();
        $medicines = Medicine::query()->get();

        if ($prescriptions->isEmpty() || $medicines->isEmpty()) {
            return;
        }

        foreach ($prescriptions as $prescription) {
            $selectedMedicines = $medicines->shuffle()->take(rand(2, min(5, $medicines->count())));

            foreach ($selectedMedicines as $medicine) {
                PrescriptionMedicine::firstOrCreate(
                    [
                        'prescription_id' => $prescription->id,
                        'medicine_id' => $medicine->id,
                    ],
                    [
                        'morning_dose' => fake()->randomElement(['1', '0.5', '2', null]),
                        'afternoon_dose' => fake()->randomElement(['1', '0.5', '2', null]),
                        'night_dose' => fake()->randomElement(['1', '0.5', '2', null]),
                        'duration' => fake()->randomElement(['5 days', '7 days', '10 days', '2 weeks', '1 month']),
                        'instruction' => fake()->optional()->randomElement(['After meal', 'Before meal', 'With food', 'At bedtime']),
                    ]
                );
            }
        }
    }
}
