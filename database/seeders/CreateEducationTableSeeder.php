<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;

class CreateEducationTableSeeder extends Seeder
{
    public function run(): void
    {
        $educationItems = [
            ['degree' => 'MBBS', 'institution' => 'Bachelor of Medicine & Surgery', 'year_completed' => 2008, 'details' => 'Completed primary medical education with clinical training in patient care and diagnosis.', 'type' => 'Education'],
            ['degree' => 'DDV (DU)', 'institution' => 'Diploma in Dermatology & Venereology', 'year_completed' => 2012, 'details' => 'Specialized training in skin diseases and sexual health treatment.', 'type' => 'Certification'],
            ['degree' => 'CCD (BIRDEM)', 'institution' => 'Certificate Course in Diabetes', 'year_completed' => 2014, 'details' => 'Advanced education in diabetes diagnosis, management, and lifestyle care.', 'type' => 'Certification'],
            ['degree' => 'FCGP', 'institution' => 'Family Medicine Certification', 'year_completed' => 2016, 'details' => 'Professional training in family healthcare and chronic disease management.', 'type' => 'Certification'],
            ['degree' => 'PGT (Medicine)', 'institution' => 'Post Graduate Training in Medicine', 'year_completed' => 2018, 'details' => 'Clinical training in internal medicine and patient management.', 'type' => 'Certification'],
            ['degree' => 'STD & Dermatological Surgery Training', 'institution' => 'Specialized Clinical Training', 'year_completed' => 2019, 'details' => 'Hands-on training in STD treatment, leprosy care, hair transplant, and skin procedures.', 'type' => 'Certification'],
            ['degree' => 'Male Infertility Training (USA)', 'institution' => 'International Fertility Training', 'year_completed' => 2021, 'details' => 'Advanced learning in male reproductive and infertility management.', 'type' => 'Certification'],
            ['degree' => 'Fellowship in Sexual Medicine', 'institution' => 'Sexual Medicine Fellowship (India)', 'year_completed' => 2023, 'details' => 'Professional fellowship focused on modern sexual health treatment and counseling.', 'type' => 'Certification'],
        ];

        foreach ($educationItems as $education) {
            Education::updateOrCreate(['degree' => $education['degree']], $education);
        }
    }
}
