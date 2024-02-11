<?php

namespace App\Http\Controllers;

use App\Http\Resources\DealResource;
use App\Models\Deal;
use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DealController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Deal::class, 'deal');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $organization = Organization::find(session('organization_id'));

        if ($request->input('query')) {
            $searchResults = Deal::search($request->input('query'))
                ->orderBy('id')
                ->whereIn('id', $organization->deals->pluck('id')->toArray())
                ->paginate(10);

            return Inertia::render('Deals', [
                'pagination' => DealResource::collection($searchResults),
            ]);
        }

        $dealsPagination = $organization
            ->deals()
            ->orderBy('id')
            ->cursorPaginate(10);

        return Inertia::render('Deals', [
            'pagination' => DealResource::collection($dealsPagination),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|integer|exists:leads,id',
            'contact_id' => 'required|integer|exists:contacts,id',
            'company_id' => 'required|integer|exists:companies,id',
            'name' => 'required|string',
            'value' => 'required|numeric',
            'currency' => 'required|string',
            'close_date' => 'required|date',
            'status' => 'required|string',
            'description' => 'required|string',
        ]);

        $deal = Deal::create([
            ...$validated,
            'organization_id' => session('organization_id'),
            'user_id' => auth()->id(),
        ]);

        return back()->with(['message' => 'Deal created successfully!', 'type' => 'success']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'lead_id' => 'sometimes|integer|exists:leads,id',
            'contact_id' => 'sometimes|integer|exists:contacts,id',
            'company_id' => 'sometimes|integer|exists:companies,id',
            'name' => 'sometimes|string',
            'value' => 'sometimes|numeric',
            'currency' => 'sometimes|string',
            'close_date' => 'sometimes|date',
            'status' => 'sometimes|string',
            'description' => 'sometimes|string',
        ]);

        $deal->update($validated);

        return back()->with(['message' => 'Deal updated successfully!', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        $deal->delete();

        return back()->with(['message' => 'Deal deleted successfully!', 'type' => 'success']);
    }
}
