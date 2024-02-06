<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Contact::class, 'contact');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $organization = Organization::find(session('organization_id'));

        if ($request->input('query')) {
            $searchResults = Contact::search($request->input('query'))
                ->orderBy('first_name')
                ->orderBy('id')
                ->whereIn('id', $organization->contacts->pluck('id')->toArray())
                ->paginate(10);

            return Inertia::render('Contacts', [
                'pagination' => ContactResource::collection($searchResults),
            ]);
        }

        $contactsPagination = $organization
            ->contacts()
            ->orderBy('first_name')
            ->orderBy('id')
            ->cursorPaginate(10);

        return Inertia::render('Contacts', [
            'pagination' => ContactResource::collection($contactsPagination),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'max:255'],
            'organization_name' => ['required', 'max:255'],
            'job_title' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
        ]);

        $organization = Organization::find(session('organization_id'));

        $contact = $organization->contacts()->create([
            ...$validated,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with(['message' => 'Contact created.', 'type' => 'success']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $validated = $request->validate([
            'first_name' => ['sometimes', 'required', 'max:255'],
            'last_name' => ['sometimes', 'required', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255'],
            'phone_number' => ['sometimes', 'required', 'max:255'],
            'organization_name' => ['sometimes', 'required', 'max:255'],
            'job_title' => ['sometimes', 'required', 'max:255'],
            'description' => ['sometimes', 'required', 'max:255'],
        ]);

        $contact->update($validated);

        return redirect()->back()->with(['message' => 'Contact updated.', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        // check if contact has leads
        if ($contact->leads()->exists()) {
            return redirect()->back()->with(['message' => 'Contact has leads and cannot be deleted.', 'type' => 'failure']);
        }

        $contact->delete();

        return redirect()->back()->with(['message' => 'Contact deleted.', 'type' => 'success']);
    }
}
