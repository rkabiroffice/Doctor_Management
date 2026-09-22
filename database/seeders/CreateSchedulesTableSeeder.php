<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class CreateSchedulesTableSeeder extends Seeder
{
    public function run(): void
    {
        $clinicDhaka = Clinic::where('name', 'Pure Scientific Diagnostic Services Ltd. Besides Lazz Pharma Ltd.')->firstOrFail();
        $clinicCumilla = Clinic::where('name', '1 No. Hospital Gate, Cumilla.')->firstOrFail();

        $clinicSchedules = [
            ['clinic_id' => $clinicDhaka->id, 'day_name' => 'Thursday', 'day_order' => 1, 'start_time' => '14:00:00', 'end_time' => '22:00:00', 'appointment_limit' => 20, 'is_closed' => false],
            ['clinic_id' => $clinicDhaka->id, 'day_name' => 'Friday', 'day_order' => 2, 'start_time' => '14:00:00', 'end_time' => '22:00:00', 'appointment_limit' => 20, 'is_closed' => false],
            ['clinic_id' => $clinicDhaka->id, 'day_name' => 'Saturday', 'day_order' => 3, 'start_time' => '14:00:00', 'end_time' => '22:00:00', 'appointment_limit' => 20, 'is_closed' => false],
            ['clinic_id' => $clinicCumilla->id, 'day_name' => 'Monday', 'day_order' => 1, 'start_time' => '13:00:00', 'end_time' => '21:00:00', 'appointment_limit' => 20, 'is_closed' => false],
            ['clinic_id' => $clinicCumilla->id, 'day_name' => 'Tuesday', 'day_order' => 2, 'start_time' => '13:00:00', 'end_time' => '21:00:00', 'appointment_limit' => 20, 'is_closed' => false],
            ['clinic_id' => $clinicCumilla->id, 'day_name' => 'Wednesday', 'day_order' => 3, 'start_time' => '13:00:00', 'end_time' => '21:00:00', 'appointment_limit' => 20, 'is_closed' => false],
        ];

        foreach ($clinicSchedules as $schedule) {
            Schedule::updateOrCreate(
                ['clinic_id' => $schedule['clinic_id'], 'day_name' => $schedule['day_name']],
                $schedule
            );
        }
    }
}
