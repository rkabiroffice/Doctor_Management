<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class CreateBlogsTableSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            ['title' => 'Common Causes of Male Sexual Weakness', 'excerpt' => 'Learn the medical and lifestyle reasons behind sexual performance issues.', 'content' => 'A detailed look at how health, stress, hormones, and lifestyle can affect male sexual performance and how treatment can help.', 'image_url' => 'https://images.pexels.com/photos/4056838/pexels-photo-4056838.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 1],
            ['title' => 'How to Improve Female Sexual Health', 'excerpt' => 'Important tips for hormonal balance and intimate wellness.', 'content' => 'Guidance on nutrition, communication, medical evaluation, and lifestyle changes to support women’s sexual health.', 'image_url' => 'https://images.pexels.com/photos/3760065/pexels-photo-3760065.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 2],
            ['title' => 'Early Signs of Diabetes', 'excerpt' => 'Understand the warning symptoms of diabetes before complications begin.', 'content' => 'Recognizing early warning signs of diabetes enables prompt diagnosis and better long-term management.', 'image_url' => 'https://images.pexels.com/photos/4056538/pexels-photo-4056538.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 3],
            ['title' => 'Best Treatment for Acne & Pimples', 'excerpt' => 'Modern ways to reduce acne and improve skin health.', 'content' => 'Learn evidence-based treatment strategies for acne, pore care, and preventing acne scars.', 'image_url' => 'https://images.pexels.com/photos/3762650/pexels-photo-3762650.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 4],
            ['title' => 'Male Infertility: Causes & Solutions', 'excerpt' => 'Medical reasons behind infertility and available treatments.', 'content' => 'An overview of male reproductive health, sperm quality factors, and current treatment options.', 'image_url' => 'https://images.pexels.com/photos/4327229/pexels-photo-4327229.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 5],
            ['title' => 'Understanding STD Symptoms', 'excerpt' => 'Important facts about sexually transmitted infections and prevention.', 'content' => 'Key symptoms, testing advice, and safe treatment practices for STDs and STIs.', 'image_url' => 'https://images.pexels.com/photos/5212329/pexels-photo-5212329.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 6],
            ['title' => 'Hair Fall: Causes & Prevention', 'excerpt' => 'How stress, hormones, and nutrition affect hair health.', 'content' => 'Insights on what causes hair loss and practical steps to preserve hair and scalp health.', 'image_url' => 'https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 7],
            ['title' => 'Skin Allergy During Seasonal Changes', 'excerpt' => 'Ways to prevent itching, rash, and skin irritation.', 'content' => 'Advice on protecting your skin during seasonal allergy triggers and environmental changes.', 'image_url' => 'https://images.pexels.com/photos/6465128/pexels-photo-6465128.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 8],
            ['title' => 'Healthy Lifestyle for Better Sexual Health', 'excerpt' => 'Daily habits that improve confidence and intimate wellness.', 'content' => 'A lifestyle guide for stronger sexual health, improved energy, and emotional wellbeing.', 'image_url' => 'https://images.pexels.com/photos/3768126/pexels-photo-3768126.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 9],
            ['title' => 'Foods That Help Diabetes Control', 'excerpt' => 'Healthy diet suggestions for diabetic patients.', 'content' => 'Nutrition tips and food choices that support stable blood sugar and better diabetes outcomes.', 'image_url' => 'https://images.pexels.com/photos/5938/food-salad-healthy-lunch.jpg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 10],
            ['title' => 'Female Fertility Health Tips', 'excerpt' => 'Important medical advice for reproductive wellness.', 'content' => 'Supportive tips for women seeking to improve fertility and reproductive health naturally and medically.', 'image_url' => 'https://images.pexels.com/photos/3831659/pexels-photo-3831659.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 11],
            ['title' => 'Importance of Regular Health Checkups', 'excerpt' => 'Why preventive healthcare is essential for long-term wellness.', 'content' => 'Regular health screening helps detect problems early and keeps chronic conditions under control.', 'image_url' => 'https://images.pexels.com/photos/4052171/pexels-photo-4052171.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 12],
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(['title' => $blog['title']], array_merge($blog, ['is_published' => true]));
        }
    }
}
