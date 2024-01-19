<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationMember;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memberships = auth()->user()->memberships()->with(['organization.user'])->get();
        $invitations = auth()->user()->invitations()->where('status', 'pending')->with('organization.user')->get();

        return Inertia::render('Organizations', [
            'memberships' => $memberships,
            'invitations' => $invitations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $organization = Organization::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
            'created_at' => now(),
        ]);

        $organization->memberships()->save(OrganizationMember::make([
            'user_id' => auth()->id(),
        ]));

        return to_route('organizations.index')->with(['message' => 'Organization created successfully!', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();
        session()->forget('organization_id');
    }
}
