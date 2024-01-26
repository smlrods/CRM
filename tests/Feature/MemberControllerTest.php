<?php

namespace Tests\Feature\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Models\OrganizationMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class MemberControllerTest extends TestCase
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
        $role = Role::create(['name' => 'owner', 'organization_id' => $organization->id]);

        // Set the user as the logged in user
        $this->actingAs($user);

        // Set the organization as the current organization
        $this->session(['organization_id' => $organization->id]);

        // Set the organization as the current team
        setPermissionsTeamId($organization->id);

        $user->assignRole($role->name);

        // Clear the cached permissions
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_members_can_be_listed(): void
    {
        // Create organization members
        $members = User::factory()->count(3)->create();
        $organization = Organization::find(session('organization_id'));

        $members->each(fn($member) => $organization->members()->attach($member->id));

        // dd($organization->members->count());

        // Make the index request
        $response = $this->get(route('members.index'));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // dd($response->getOriginalContent());

        // Assert the fetched members match the created members
        $response->assertInertia(
            fn($page) => $page->component('Members')
            ->has(
                'pagination.data',
                4 // 3 members + 1 owner
            )
        );
    }

    public function test_member_can_be_deleted(): void
    {
        // Create organization member
        $member = User::factory()->create();
        $organization = Organization::find(session('organization_id'));
        $organization->members()->attach($member);
        $membership = $organization->memberships()->where('user_id', $member->id)->first();

        // Make the delete request
        $response = $this->delete(route('members.destroy', $membership));

        // Assert the member was deleted
        $this->assertDatabaseMissing(OrganizationMember::class, ['id' => $member->id]);

        // Assert the response was a redirect back
        $response->assertRedirect();

        // Assert the session has the success message
        $response->assertSessionHas('message', 'Member deleted successfully.');
        $response->assertSessionHas('type', 'success');
    }

    public function test_member_cannot_be_deleted_if_owner(): void
    {
        // Create organization owner
        $owner = User::factory()->create();
        $organization = Organization::find(session('organization_id'));
        $organization->update(['user_id' => $owner->id]);
        $organization->members()->attach($owner);
        $membership = $organization->memberships()->where('user_id', $owner->id)->first();

        // Make the delete request
        $response = $this->delete(route('members.destroy', $membership));

        // Assert the member was not deleted
        $this->assertDatabaseHas(User::class, ['id' => $owner->id]);

        // Assert the response has the failure message
        $response->assertSessionHas('message', 'You cannot remove the owner of the organization.');
        $response->assertSessionHas('type', 'failure');
    }
}
