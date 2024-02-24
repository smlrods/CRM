<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyDataResource;
use App\Http\Resources\CompanyResource;
use App\Models\Address;
use App\Models\Company;
use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $organization = Organization::find(session('organization_id'));

        if ($request->input('query')) {
            $searchResults = Company::search($request->input('query'))
                ->orderBy('name')
                ->orderBy('id')
                ->whereIn('id', $organization->companies->pluck('id')->toArray())
                ->paginate(10);

            return Inertia::render('Companies', [
                'pagination' => CompanyResource::collection($searchResults),
            ]);
        }

        $contactsPagination = $organization
            ->companies()
            ->orderBy('name')
            ->orderBy('id')
            ->cursorPaginate(10);

        return Inertia::render('Companies', [
            'pagination' => CompanyResource::collection($contactsPagination),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'website' => 'required|string',
            'industry' => 'required|string',
            'description' => 'required|string',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
        ]);

        $organization = Organization::find(session('organization_id'));

        $address = Address::create([
            'street_address' => $validated['street_address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['zip_code'],
            'organization_id' => $organization->id,
        ]);

        $company = $organization->companies()->create([
            'name' => $validated['name'],
            'website' => $validated['website'],
            'industry' => $validated['industry'],
            'description' => $validated['description'],
            'address_id' => $address->id,
            'organization_id' => $organization->id,
        ]);

        return back()->with(['message' => 'Company created successfully.', 'type' => 'success']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'website' => 'sometimes|string',
            'industry' => 'sometimes|string',
            'address_id' => 'sometimes|integer',
            'description' => 'sometimes|string',
            'street_address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'zip_code' => 'sometimes|string',
        ]);

        // create array of defined address fields
        $addressFields = array_filter($validated, function ($key) {
            return in_array($key, ['street_address', 'city', 'state', 'zip_code']);
        }, ARRAY_FILTER_USE_KEY);

        // create array of defined company fields
        $companyFields = array_filter($validated, function ($key) {
            return in_array($key, ['name', 'website', 'industry', 'description']);
        }, ARRAY_FILTER_USE_KEY);

        // if address fields are set, update address
        if (!empty($addressFields)) {
            $address = Address::find($company->address_id);

            $address->update($addressFields);

            $company->update($validated);
        }

        // if company fields are set, update company
        if (!empty($companyFields)) {
            $company->update($companyFields);
        }

        return back()->with(['message' => 'Company updated successfully.', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return back()->with(['message' => 'Company deleted successfully.', 'type' => 'success']);
    }

    public function getCompaniesOptions(Request $request)
    {
        $organization = Organization::find(session('organization_id'));

        if ($request->input('query')) {
            $companies = Company::search($request->input('query'))
                ->orderBy('name')
                ->orderBy('id')
                ->take(10)
                ->get();

            return CompanyDataResource::collection($companies);
        }

        $companies = $organization->companies()->orderBy('name')->orderBy('id')->take(10)->get();

        return CompanyDataResource::collection($companies);
    }
}
