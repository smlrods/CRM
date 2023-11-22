<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => '12345678',
        ])->assignRole(RolesEnum::ADMINISTRATOR);
    }
}
