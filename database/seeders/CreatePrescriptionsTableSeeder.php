<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Database\Seeder;

class CreatePrescriptionsTableSeeder extends Seeder
{
    public function run(): void
    {
        Appointment::query()
            ->whereIn('status', ['completed', 'confirmed'])
            ->get()
            ->each(fn (Appointment $appointment) => Prescription::firstOrCreate(
                ['appointment_id' => $appointment->id],
                Prescription::factory()->make(['appointment_id' => $appointment->id])->toArray()
            ));
    }
}
