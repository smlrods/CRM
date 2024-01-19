<?php

namespace Tests\Feature\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Organization;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and organization
        $user = User::factory()->create();
        $organization = Organization::create(['name' => $this->faker->unique()->company, 'user_id' => $user->id, 'created_at' => now()]);
        $organization->memberships()->create(['user_id' => $user->id]);

        // Set the user as the logged in user
        $this->actingAs($user);

        // Set the organization as the current organization
        $this->session(['organization_id' => $organization->id]);

        // Set the organization as the current team
        setPermissionsTeamId($organization->id);

        // Clear the cached permissions
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_roles_can_be_listed(): void
    {
        // Create roles
        $roles = Role::factory()->count(3)->create();

        // Make the index request
        $response = $this->get(route('roles.index'));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the fetched roles match the created roles
        $response->assertInertia(fn($page) => $page->component('Roles')
            ->has('pagination.data', 3));
    }

    public function test_role_can_be_created_with_valid_data(): void
    {
        // Create permissions
        $permissions = Permission::factory()->count(3)->create();

        // Make the create request
        $data = [
            'name' => $this->faker->unique()->word,
            'permissions' => $permissions->pluck('id')->toArray(),
        ];

        // Assert the role was created
        $response = $this->post(route('roles.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Role created successfully.');
        $response->assertSessionHas('type', 'success');

        // Assert the role has the correct name
        $this->assertDatabaseHas('roles', [
            'name' => $data['name'],
        ]);

        // Assert the role has the correct permissions
        $role = Role::where('name', $data['name'])->first();
        $this->assertCount(count($data['permissions']), $role->permissions);
        $this->assertTrue($role->permissions->pluck('id')->contains($permissions->first()->id));
    }

    public function test_role_cannot_be_created_with_invalid_data(): void
    {
        // Make the create request
        $response = $this->post(route('roles.store'), []);

        // Assert the role was not created
        $response->assertSessionHasErrors(['name', 'permissions']);
    }

    public function test_role_can_be_updated_with_valid_data(): void
    {
        // Create permissions
        $permissions = Permission::factory()->count(3)->create();

        // Create a role
        $role = Role::factory()->create();

        // Assign the first permission to the role
        $role->syncPermissions([$permissions[0]]);

        // Make the update request
        $data = [
            'name' => $this->faker->unique()->word,
            'permissions' => $permissions->pluck('id')->toArray(),
        ];

        $response = $this->put(route('roles.update', $role), $data);

        // Assert the role was updated
        $response->assertRedirect();
        $response->assertSessionHas('message', 'Role updated successfully.');
        $response->assertSessionHas('type', 'success');

        // Assert the role has the new name
        $this->assertDatabaseHas('roles', [
            'name' => $data['name'],
        ]);

        // Assert the role has the new permissions
        $role = $role->fresh();

        $this->assertCount(count($data['permissions']), $role->permissions);
        $this->assertTrue($role->permissions->pluck('id')->contains($permissions->first()->id));
    }

    public function test_role_cannot_be_updated_with_invalid_data(): void
    {
        // Create a role
        $role = Role::factory()->create();

        // Make the update request
        $response = $this->put(route('roles.update', $role), []);

        // Assert the role was not updated
        $response->assertSessionHasErrors(['name', 'permissions']);
    }

    public function test_role_can_be_deleted(): void
    {
        // Create a role
        $role = Role::factory()->create();

        // Make the delete request
        $response = $this->delete(route('roles.destroy', $role));

        // Assert the role was deleted
        $this->assertDatabaseMissing(Role::class, [
            'id' => $role->id,
            'name' => $role->name,
        ]);

        // Assert the response was a redirect back
        $response->assertRedirect();

        // Assert the session has the success message
        $response->assertSessionHas('message', 'Role deleted successfully.');
        $response->assertSessionHas('type', 'success');
    }
}
