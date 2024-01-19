<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Http\Resources\MemberRolesResource;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Models\OrganizationMember;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeresource(organizationmember::class, 'member');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $organization = Organization::find(session('organization_id'));

        $roles = $organization->roles()->orderBy('name')->select(['id', 'name'])->get();

        // If the user is searching for a member, return the search results.
        if ($request->input('query')) {
            $searchResults = User::search($request->input('query'))
                ->orderBy('first_name')
                ->whereIn('id', $organization->members->pluck('id')->toArray())
                ->paginate(10);

            return Inertia::render('Members', [
                'pagination' => MemberResource::collection($searchResults),
                'rolesData' => MemberRolesResource::collection($roles),
            ]);
        }

        // Otherwise, return the members of the organization with their memberships.
        $membersPagination = $organization
                ->members()
                ->orderBy('first_name')
                ->orderBy('users.id')
                ->cursorPaginate(10, ['users.id', 'users.first_name', 'users.last_name', 'users.email']);

        return Inertia::render('Members', [
            'pagination' => MemberResource::collection($membersPagination),
            'rolesData' => MemberRolesResource::collection($roles),
        ]);
    }

    public function update(Request $request, OrganizationMember $member)
    {
        $member->update($request->validate([
            'role_id' => 'required|exists:roles,id',
        ]));

        $role = $member->organization->roles()->find($request->input('role_id'));

        $member->user->syncRoles($role->name);

        return back()->with(['message' => 'Member updated successfully.', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrganizationMember $member)
    {
        // If the user is the owner of the organization, return an error.
        if ($member->organization->user_id === $member->user_id) {
            return back()->with(['message' => 'You cannot remove the owner of the organization.', 'type' => 'failure']);
        }

        // Get the invitation for the member.
        $invitation = OrganizationInvitation::where('user_id', $member->user_id)->where('organization_id', $member->organization_id)->first();

        if ($invitation) {
            $invitation->delete();
        }

        $member->delete();

        // If the member is the current user, forget the organization_id session variable.
        if ($member->user_id === auth()->user()->id) {
            session()->forget('organization_id');
        }

        return back()->with(['message' => 'Member deleted successfully.', 'type' => 'success']);
    }
}
