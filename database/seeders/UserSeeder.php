<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->isLocal()) {
            User::factory()
                ->count(10)
                ->has(Project::factory()->count(3)->hasTasks(3))
                ->create();
        }

        User::create([
            'name' => env('ADMIN_NAME', 'admin'),
            'email' => env('ADMIN_EMAIL', 'admin@email.com'),
            'password' => env('ADMIN_PASSWORD', '123'),
            'email_verified_at' => now(),
        ])->assignRole(RolesEnum::ADMINISTRATOR);
    }
}
