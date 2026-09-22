<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class CreateServicesTableSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['title' => 'Male Sexual Health', 'description' => 'Treatment for erectile dysfunction, premature ejaculation, and low sexual performance.', 'icon' => 'heart', 'sort_order' => 1],
            ['title' => 'Female Sexual Wellness', 'description' => 'Professional consultation for female sexual discomfort and hormonal health.', 'icon' => 'sparkles', 'sort_order' => 2],
            ['title' => 'STD & STI Treatment', 'description' => 'Confidential diagnosis and treatment for sexually transmitted diseases.', 'icon' => 'shield-check', 'sort_order' => 3],
            ['title' => 'Male Infertility Care', 'description' => 'Evaluation and treatment for low sperm count and reproductive issues.', 'icon' => 'dna', 'sort_order' => 4],
            ['title' => 'Female Fertility Consultation', 'description' => 'Medical guidance and fertility support for women.', 'icon' => 'sparkles', 'sort_order' => 5],
            ['title' => 'Skin Allergy Treatment', 'description' => 'Treatment for itching, rashes, eczema, and allergic skin reactions.', 'icon' => 'exclamation-circle', 'sort_order' => 6],
            ['title' => 'Acne & Pimples Care', 'description' => 'Advanced treatment for acne scars, pimples, and oily skin problems.', 'icon' => 'face-smile', 'sort_order' => 7],
            ['title' => 'Hair Fall & Scalp Care', 'description' => 'Diagnosis and treatment for hair loss and scalp disorders.', 'icon' => 'scissors', 'sort_order' => 8],
            ['title' => 'Diabetes Management', 'description' => 'Complete diabetic care, monitoring, and lifestyle guidance.', 'icon' => 'heart-pulse', 'sort_order' => 9],
            ['title' => 'General Medicine Consultation', 'description' => 'Treatment for fever, infection, gastric issues, and common illnesses.', 'icon' => 'stethoscope', 'sort_order' => 10],
            ['title' => 'Chronic Allergy Care', 'description' => 'Long-term management for food, dust, and seasonal allergies.', 'icon' => 'cloud-rain', 'sort_order' => 11],
            ['title' => 'Family Health Checkup', 'description' => 'Comprehensive medical consultation for men, women, and families.', 'icon' => 'family', 'sort_order' => 12],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['title' => $service['title']], array_merge($service, ['is_active' => true]));
        }
    }
}
