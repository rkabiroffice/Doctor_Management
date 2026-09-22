<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'doctor@website.com'],
            [
                'name' => 'Mr. Doctor',
                'password' => bcrypt('doctor'),
                'role_id' => Role::where('name', 'Doctor')->firstOrFail()->id,
            ]
        );
    }
}
