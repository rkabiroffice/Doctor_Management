<?php

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Seeder;

class CreateClinicsTableSeeder extends Seeder
{
    public function run(): void
    {
        Clinic::updateOrCreate(
            ['name' => 'Pure Scientific Diagnostic Services Ltd. Besides Lazz Pharma Ltd.'],
            [
                'address' => 'Dhaka Medical College Hospital Unit-2 Near Naz Farm, Dhaka',
                'city' => 'Dhaka',
                'phones' => ['01647-386185'],
                'map_embed_url' => null,
                'is_active' => true,
            ]
        );

        Clinic::updateOrCreate(
            ['name' => '1 No. Hospital Gate, Cumilla.'],
            [
                'address' => 'Opposite “Molla House” Swapna Super Market, Cumilla',
                'city' => 'Cumilla',
                'phones' => ['01727-375664'],
                'map_embed_url' => null,
                'is_active' => true,
            ]
        );
    }
}
