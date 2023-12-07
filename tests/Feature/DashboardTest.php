<?php

namespace Tests\Feature;

use App\Enums\RolesEnum;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $seeder = RolesAndPermissionsSeeder::class;

    /**
     * Test the dashboard route.
     *
     * @return void
     */
    public function test_dashboard_route()
    {
        $users = User::factory()
            ->count(10)
            ->has(Project::factory()->count(3)->hasTasks(3))
            ->create();

        $users->each(fn(User $user) => $user->assignRole(fake()->randomElement(RolesEnum::toArray())));

        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);

        // Make a GET request to the dashboard route
        $response = $this->actingAs($user)->get('/');

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the response contains the expected data
        $response->assertViewHas('userChartData', User::getCountChartDataForWeek());
        $response->assertViewHas('clientChartData', Client::getCountChartDataForWeek());
        $response->assertViewHas('projectChartData', Project::getCountChartData());
        $response->assertViewHas('taskChartData', Task::getCountChartData());
    }
}
