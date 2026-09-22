<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class CreateReviewsTableSeeder extends Seeder
{
    public function run(): void
    {
        Review::factory()->count(6)->create();
    }
}
