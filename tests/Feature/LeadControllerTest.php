<?php

namespace Tests\Feature\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class LeadControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $user;
    protected $organization;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and organization
        $user = User::factory()->create();
        $organization = Organization::create(['name' => $this->faker->unique()->company, 'user_id' => $user->id, 'created_at' => now()]);

        $organization->memberships()->create(['user_id' => $user->id]);
        $role = Role::create(['name' => 'owner', 'organization_id' => $organization->id]);

        // seed permissions
        $this->seed(RolesAndPermissionsSeeder::class);

        // Set the user as the logged in user
        $this->actingAs($user);

        // Set the organization as the current organization
        $this->session(['organization_id' => $organization->id]);

        // Set the organization as the current team
        setPermissionsTeamId($organization->id);

        $user->assignRole($role->name);

        // Set the previous URL
        $this->from(route('leads.index'));

        // Clear the cached permissions
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Create user and organization properties
        $this->user = $user;
        $this->organization = $organization;
    }

    public function test_leads_can_be_listed(): void
    {
        $organization = $this->organization;
        $user = $this->user;

        // Create company and contact
        $companies = Company::factory(3)->create(['organization_id' => $organization->id, 'address_id' => Address::factory(['organization_id' => $organization->id])]);
        $contacts = Contact::factory(3)->create(['organization_id' => $organization->id, 'user_id' => $user->id]);
        $leads = collect();

        // Create organization leads
        $companies->each(function (Company $company, $index) use ($organization, $contacts, $leads) {
            $lead = Lead::factory()->create([
                'company_id' => $company->id,
                'contact_id' => $contacts[$index]->id,
                'organization_id' => $organization->id,
            ]);

            $leads->push($lead);
        });

        // Make the index request
        $response = $this->get(route('leads.index'));

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the fetched leads match the created leads
        $response->assertInertia(
            fn($page) => $page->component('Leads')
            ->has(
                'pagination.data',
                3
            )
        );
    }

    public function test_lead_can_be_created(): void
    {
        $organization = $this->organization;
        $user = $this->user;

        // Create a company and contact
        $company = Company::factory()->create(['organization_id' => $organization->id, 'address_id' => Address::factory(['organization_id' => $organization->id])]);
        $contact = Contact::factory()->create(['organization_id' => $organization->id, 'user_id' => $user->id]);

        // Make the store request
        $response = $this->post(route('leads.store'), [
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'status' => 'open',
            'source' => 'website',
            'description' => 'Test lead description',
        ]);

        // Assert the lead was created
        $this->assertDatabaseHas(Lead::class, [
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'status' => 'open',
            'source' => 'website',
            'description' => 'Test lead description',
        ]);

        $response->assertStatus(302);

        // Assert the response was a redirect back
        $response->assertRedirect(route('leads.index'));

        $response->assertSessionHasNoErrors();

        // Assert the session has the success message
        $response->assertSessionHas('message', 'Lead created successfully');
        $response->assertSessionHas('type', 'success');
    }

    public function test_lead_can_be_updated(): void
    {
        $organization = $this->organization;
        $user = $this->user;

        $company = Company::factory()->create(['organization_id' => $organization->id, 'address_id' => Address::factory(['organization_id' => $organization->id])]);
        $contact = Contact::factory()->create(['organization_id' => $organization->id, 'user_id' => $user->id]);

        // Create a lead
        $lead = Lead::factory()->create([
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'organization_id' => $organization->id,
        ]);

        // Make the update request
        $response = $this->put(route('leads.update', $lead), [
            'status' => 'closed',
            'source' => 'referral',
            'description' => 'Updated lead description',
        ]);

        // Assert the lead was updated
        $this->assertDatabaseHas(Lead::class, [
            'id' => $lead->id,
            'status' => 'closed',
            'source' => 'referral',
            'description' => 'Updated lead description',
        ]);

        // Assert the response was a redirect back
        $response->assertRedirect();

        // Assert the session has the success message
        $response->assertSessionHas('message', 'Lead updated successfully');
        $response->assertSessionHas('type', 'success');
    }

    public function test_lead_can_be_deleted(): void
    {
        $organization = $this->organization;
        $user = $this->user;

        $company = Company::factory()->create(['organization_id' => $organization->id, 'address_id' => Address::factory(['organization_id' => $organization->id])]);
        $contact = Contact::factory()->create(['organization_id' => $organization->id, 'user_id' => $user->id]);

        // Create a lead
        $lead = Lead::factory()->create([
            'company_id' => $company->id,
            'contact_id' => $contact->id,
            'organization_id' => $organization->id,
        ]);

        // Make the delete request
        $response = $this->delete(route('leads.destroy', $lead));

        // Assert the lead was deleted
        $this->assertDatabaseMissing(Lead::class, ['id' => $lead->id]);

        // Assert the response was a redirect back
        $response->assertRedirect();

        // Assert the session has the success message
        $response->assertSessionHas('message', 'Lead deleted successfully');
        $response->assertSessionHas('type', 'success');
    }
}
