<?php

namespace Database\Seeders;

use App\Models\Biography;
use Illuminate\Database\Seeder;

class CreateBiographiesTableSeeder extends Seeder
{
    public function run(): void
    {
        Biography::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Professional Biography',
                'subtitle' => 'Experienced physician with specialized training in sexual medicine and dermatology.',
                'content' => 'Dr. Md. Raihan Uddin completed his MBBS and advanced medical training in dermatology, diabetes care, and family medicine. He has received professional training in sexual medicine, male infertility, STD management, dermatological procedures, and general medicine. He currently provides consultation for male and female sexual health, skin diseases, infertility issues, diabetes management, allergy treatment, and chronic medical conditions through his Dhaka and Cumilla chambers.',
                'video_url' => null,
                'youtube_url' => null,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );
    }
}
