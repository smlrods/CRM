<?php

namespace Tests\Feature;

use App\Enums\RolesEnum;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $seeder = RolesAndPermissionsSeeder::class;

    public function test_index_with_query()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);

        Project::factory()->count(10)->create(['user_id' => $user->id]);
        $project1 = Project::factory()->create(['title' => 'Test Project 1', 'user_id' => $user->id]);
        $project2 = Project::factory()->create(['title' => 'Test Project 2', 'user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('projects.index', ['query' => 'Test Project 1']));

        $response->assertStatus(200);
        $response->assertViewHas('items');
        $response->assertViewHas('resourceName', 'projects');
        $this->assertTrue($response->viewData('items')->contains($project1));
        $this->assertFalse($response->viewData('items')->contains($project2));
    }

    public function test_index_without_query()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);

        Project::factory()->count(10)->create(['user_id' => $user->id]);
        $project1 = Project::factory()->create(['title' => 'Test Project 1', 'user_id' => $user->id]);
        $project2 = Project::factory()->create(['title' => 'Test Project 2', 'user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertViewHas('items');
        $response->assertViewHas('resourceName', 'projects');
        $this->assertTrue($response->viewData('items')->contains($project1));
        $this->assertTrue($response->viewData('items')->contains($project2));
    }

    public function test_create()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);
        $client = Client::factory()->create();

        $response = $this->actingAs($user)->get(route('projects.create'));

        $response->assertStatus(200);
        $response->assertViewHas('users');
        $response->assertViewHas('clients');
    }

    public function test_store()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);

        $projectData = Project::factory()->make([
            'user_id' => $user->id,
            'status' => 'completed',
        ])->toArray();

        $response = $this->actingAs($user)->post(route('projects.store'), $projectData);

        $createdProject = Project::latest('id')->first();

        $response->assertRedirect(route('projects.show', $createdProject));
        $this->assertDatabaseHas('projects', $projectData);
    }

    public function test_show()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);

        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('projects.show', $project));

        $response->assertStatus(200);
        $response->assertViewHas('project');
    }

    public function test_edit()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('projects.edit', $project));

        $response->assertStatus(200);
        $response->assertViewHas('project');
        $response->assertViewHas('users');
        $response->assertViewHas('clients');
    }

    public function test_update()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);
        $project = Project::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            ...$project->toArray(),
            'status' => 'completed',
            'title' => 'Updated Project Name',
        ];

        $response = $this->actingAs($user)->put(route('projects.update', $project), $updatedData);

        $response->assertRedirect(route('projects.show', $project));
        $this->assertDatabaseHas('projects', $updatedData);
    }

    public function test_destroy()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'));
        $this->assertModelMissing($project);
    }

    public function test_delete_project_deletes_all_tasks()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);
        $project = Project::factory()->create(['user_id' => $user->id]);
        $task1 = Task::factory()->create(['project_id' => $project->id]);
        $task2 = Task::factory()->create(['project_id' => $project->id]);

        $response = $this->actingAs($user)->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'));
        $this->assertModelMissing($project);
        $this->assertModelMissing($task1);
        $this->assertModelMissing($task2);
    }
}
