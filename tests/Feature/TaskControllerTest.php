<?php

namespace Tests\Feature;

use App\Enums\RolesEnum;
use App\Enums\TaskStatus;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Contracts\Role;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $seeder = RolesAndPermissionsSeeder::class;

    public function test_index_with_query()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);

        $project = Project::factory()->create(['user_id' => $user->id]);

        $task1 = Task::factory()->create(['title' => 'Test Task 1', 'project_id' => $project->id]);
        $task2 = Task::factory()->create(['title' => 'Test Task 2', 'project_id' => $project->id]);

        $response = $this->actingAs($user)->get(route('tasks.index', ['query' => 'Test Task 1']));

        $response->assertStatus(200);
        $response->assertViewHas('items');
        $response->assertViewHas('resourceName', 'tasks');
        $this->assertTrue($response->viewData('items')->contains($task1));
        $this->assertFalse($response->viewData('items')->contains($task2));
    }

    public function test_index_without_query()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);

        $project = Project::factory()->create(['user_id' => $user->id]);

        $task1 = Task::factory()->create(['title' => 'Test Task 1', 'project_id' => $project->id]);
        $task2 = Task::factory()->create(['title' => 'Test Task 2', 'project_id' => $project->id]);

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertViewHas('items');
        $response->assertViewHas('resourceName', 'tasks');
        $this->assertTrue($response->viewData('items')->contains($task1));
        $this->assertTrue($response->viewData('items')->contains($task2));
    }

    public function test_create()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.create'));

        $response->assertStatus(200);
        $response->assertViewHas('projects');
    }

    public function test_store()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);
        $project = Project::factory()->create(['user_id' => $user->id]);

        $taskData = Task::factory()->make([
            'project_id' => $project->id,
        ])->toArray();

        $response = $this->actingAs($user)->post(route('tasks.store'), $taskData);

        $createdTask = Task::latest('id')->first();

        $response->assertRedirect(route('tasks.show', $createdTask));
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_show()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);
        $project = Project::factory()->create(['user_id' => $user->id]);

        $task = Task::factory()->create(['project_id' => $project->id]);

        $response = $this->actingAs($user)->get(route('tasks.show', $task));

        $response->assertStatus(200);
        $response->assertViewHas('task');
    }

    public function test_edit()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);
        $project = Project::factory()->create(['user_id' => $user->id]);

        $task = Task::factory()->create(['project_id' => $project->id]);

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        $response->assertStatus(200);
        $response->assertViewHas('task');
        $response->assertViewHas('projects');
    }

    public function test_update()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);
        $project = Project::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        $updatedData = [
            ...$task->toArray(),
            'title' => 'Updated Task Name',
        ];

        $response = $this->actingAs($user)->put(route('tasks.update', $task), $updatedData);

        $response->assertRedirect(route('tasks.show', $task));
        $this->assertDatabaseHas('tasks', $updatedData);
    }

    public function test_destroy()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::ADMINISTRATOR);
        $project = Project::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertModelMissing($task);
    }
}
