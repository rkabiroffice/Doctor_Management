<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use Illuminate\Database\Seeder;

class CreateAboutSectionsTableSeeder extends Seeder
{
    public function run(): void
    {
        AboutSection::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Dedicated to Better Health & Confidential Care',
                'subtitle' => 'Providing trusted healthcare solutions with modern treatment and patient-focused consultation.',
                'content' => 'Dr. Md. Raihan Uddin is an experienced physician specializing in sexual health, dermatology, infertility, diabetes, allergy, and family medicine. With advanced clinical training and years of patient care experience, he provides safe, confidential, and evidence-based treatment for both men and women. His goal is to help patients regain confidence, improve health, and achieve a better quality of life through compassionate and personalized care.',
                'image_url' => null,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );
    }
}
