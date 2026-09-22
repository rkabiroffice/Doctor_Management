<?php

namespace Database\Seeders;

use App\Models\HeroSection;
use Illuminate\Database\Seeder;

class CreateHeroSectionsTableSeeder extends Seeder
{
    public function run(): void
    {
        HeroSection::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Advanced Sexual Health, Skin & Infertility Specialist',
                'subtitle' => 'Confidential and professional treatment for male & female sexual health, skin diseases, infertility, diabetes, allergy, and general medical care with modern diagnosis and compassionate consultation.',
                'button_text' => 'Book Appointment',
                'button_link' => '#book',
                'image_url' => 'https://images.pexels.com/photos/5212348/pexels-photo-5212348.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );
    }
}
