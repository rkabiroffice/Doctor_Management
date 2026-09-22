<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class CreateSettingsTableSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Dr. Md. Raihan Uddin', 'description' => 'Website name'],
            ['key' => 'site_tagline', 'value' => 'Confidential care for sexual health, skin, infertility, diabetes, allergy, and general medicine.', 'description' => 'Website tagline'],
            ['key' => 'logo_url', 'value' => '', 'description' => 'Logo URL'],
            ['key' => 'logo_text', 'value' => 'Raihan Uddin Clinic', 'description' => 'Logo text displayed in navigation'],
            ['key' => 'favicon_url', 'value' => '', 'description' => 'Favicon URL'],
            ['key' => 'primary_color', 'value' => '#093C5D', 'description' => 'Primary brand color'],
            ['key' => 'secondary_color', 'value' => '#3B7597', 'description' => 'Secondary brand color'],
            ['key' => 'footer_text', 'value' => 'Rahman Care Clinic. All rights reserved.', 'description' => 'Footer copyright text'],
            ['key' => 'meta_description', 'value' => 'Trusted confidential care for sexual health, skin diseases, infertility, diabetes, allergy, and general medical conditions.', 'description' => 'SEO meta description'],
            ['key' => 'meta_keywords', 'value' => 'sexual health, infertility, dermatology, diabetes, allergy, general medicine, confidential care', 'description' => 'SEO keywords'],
            ['key' => 'top_notice', 'value' => 'Dr. Md. Raihan Uddin offers confidential sexual health, skin, infertility, diabetes and allergy care across Dhaka and Cumilla.', 'description' => 'Top scrolling notice text'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/rahmanclinic', 'description' => 'Facebook profile URL'],
            ['key' => 'social_facebook_pages', 'value' => json_encode(['https://facebook.com/page1', 'https://facebook.com/page2']), 'description' => 'Multiple Facebook page URLs as JSON array'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/rahmanclinic', 'description' => 'Twitter profile URL'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/rahmanclinic', 'description' => 'Instagram profile URL'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/rahmanclinic', 'description' => 'LinkedIn profile URL'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@rahmanclinic', 'description' => 'YouTube channel URL'],
            ['key' => 'social_tiktok', 'value' => 'https://tiktok.com/@rahmanclinic', 'description' => 'TikTok profile URL'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
