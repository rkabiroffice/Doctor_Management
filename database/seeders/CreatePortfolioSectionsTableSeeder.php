<?php

namespace Database\Seeders;

use App\Models\PortfolioSection;
use Illuminate\Database\Seeder;

class CreatePortfolioSectionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['section_key' => 'services', 'label' => 'Services', 'title' => 'Specialized Medical Services', 'subtitle' => 'Complete care for sexual health, skin diseases, infertility, diabetes, and general medicine.', 'content' => 'We provide modern, confidential, and patient-centered treatment services for both men and women. Every patient receives professional diagnosis, personalized treatment plans, and continuous medical support.', 'button_text' => null, 'button_link' => null, 'sort_order' => 4, 'is_active' => true],
            ['section_key' => 'education', 'label' => 'Education', 'title' => 'Education, Certification & Professional Training', 'subtitle' => 'Professional credentials that support expert clinical care.', 'content' => 'Clinical training and certifications in sexual health, dermatology, infertility, diabetes, allergy, and family medicine.', 'button_text' => null, 'button_link' => null, 'sort_order' => 5, 'is_active' => true],
            ['section_key' => 'blog', 'label' => 'Blog', 'title' => 'Health Awareness & Medical Articles', 'subtitle' => 'Educational resources about sexual health, skin care, infertility, diabetes, and healthy living.', 'content' => 'Read trusted health articles written to help patients understand symptoms, prevention methods, treatments, and healthy lifestyle practices.', 'button_text' => 'Explore Articles', 'button_link' => '#blog', 'sort_order' => 6, 'is_active' => true],
            ['section_key' => 'schedule', 'label' => 'Schedule', 'title' => 'Visit the doctor at either chamber location based on your convenience.', 'subtitle' => 'Chamber schedules for both clinics.', 'content' => 'Schedule overview.', 'button_text' => null, 'button_link' => null, 'sort_order' => 7, 'is_active' => true],
            ['section_key' => 'reviews', 'label' => 'Reviews', 'title' => 'Patient experiences built on trust, clarity, and confidentiality.', 'subtitle' => 'Authentic patient voices and outcomes.', 'content' => 'Review section heading.', 'button_text' => null, 'button_link' => null, 'sort_order' => 8, 'is_active' => true],
            ['section_key' => 'contact', 'label' => 'Contact', 'title' => 'Book a Confidential Consultation', 'subtitle' => 'Professional medical support for sexual wellness, skin care, infertility, and overall health.', 'content' => 'Schedule your appointment for private and patient-focused healthcare consultation. Patients are encouraged to bring previous reports and medical records during follow-up visits for better treatment planning.', 'button_text' => 'Book Appointment', 'button_link' => '#book', 'sort_order' => 9, 'is_active' => true],
        ];

        foreach ($sections as $section) {
            PortfolioSection::updateOrCreate(['section_key' => $section['section_key']], $section);
        }
    }
}
