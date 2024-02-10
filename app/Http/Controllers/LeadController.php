<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyDataResource;
use App\Http\Resources\ContactDataResource;
use App\Http\Resources\LeadResource;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Lead::class, 'lead');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $organization = Organization::find(session('organization_id'));

        if ($request->input('query')) {
            $searchResults = Lead::search($request->input('query'))
                ->orderBy('id')
                ->whereIn('id', $organization->leads->pluck('id')->toArray())
                ->paginate(10);

            return Inertia::render('Leads', [
                'pagination' => LeadResource::collection($searchResults),
            ]);
        }

        $leadsPagination = $organization
            ->leads()
            ->orderBy('id')
            ->cursorPaginate(10);

        return Inertia::render('Leads', [
            'pagination' => LeadResource::collection($leadsPagination),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'contact_id' => 'required|exists:contacts,id',
            'status' => ['required', Rule::in(['open', 'closed', 'converted'])],
            'source' => ['required', Rule::in(['website', 'referral', 'social_media', 'other'])],
            'description' => 'required|string',
        ]);

        $lead = Lead::create([
            'company_id' => $validated['company_id'],
            'contact_id' => $validated['contact_id'],
            'status' => $validated['status'],
            'source' => $validated['source'],
            'description' => $validated['description'],
            'created_at' => now(),
            'organization_id' => session('organization_id'),
        ]);

        return back()->with(['message' => 'Lead created successfully', 'type' => 'success']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'company_id' => 'sometimes|exists:companies,id',
            'contact_id' => 'sometimes|exists:contacts,id',
            'status' => ['sometimes', Rule::in(['open', 'closed', 'converted'])],
            'source' => ['sometimes', Rule::in(['website', 'referral', 'social_media', 'other'])],
            'description' => 'sometimes|string',
        ]);

        $lead->update($validated);

        return back()->with(['message' => 'Lead updated successfully', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return back()->with(['message' => 'Lead deleted successfully', 'type' => 'success']);
    }
}
