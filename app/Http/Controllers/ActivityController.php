<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $organization = Organization::find(session('organization_id'));

        if ($request->input('query')) {
            $searchResults = Activity::search($request->input('query'))
                ->orderBy('id')
                ->whereIn('id', $organization->activities->pluck('id')->toArray())
                ->paginate(10);

            return Inertia::render('Activities', [
                'pagination' => ActivityResource::collection($searchResults),
            ]);
        }

        $activitiesPagination = $organization
            ->activities()
            ->orderBy('id')
            ->cursorPaginate(10);

        return Inertia::render('Activities', [
            'pagination' => ActivityResource::collection($activitiesPagination),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contact_id' => 'required|integer|exists:contacts,id',
            'lead_id' => 'required|integer|exists:leads,id',
            'type' => ['required', 'string', 'in:call,email,meeting,other'],
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'description' => 'required|string',
        ]);

        $activity = Activity::create([
            'user_id' => auth()->id(),
            'contact_id' => $validated['contact_id'],
            'lead_id' => $validated['lead_id'],
            'type' => $validated['type'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'description' => $validated['description'],
            'organization_id' => session('organization_id'),
        ]);

        return redirect()->route('activities.index')
            ->with('message', 'Activity created successfully!')
            ->with('type', 'success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'contact_id' => 'sometimes|required|integer|exists:contacts,id',
            'lead_id' => 'sometimes|required|integer|exists:leads,id',
            'type' => ['sometimes', 'required', 'string', 'in:call,email,meeting,other'],
            'date' => 'sometimes|required|date',
            'time' => 'sometimes|required|date_format:H:i:s',
            'description' => 'sometimes|required|string',
        ]);

        $activity->update($validated);

        return redirect()->route('activities.index')
            ->with('message', 'Activity updated successfully!')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('activities.index')
            ->with('message', 'Activity deleted successfully!')
            ->with('type', 'success');
    }
}
