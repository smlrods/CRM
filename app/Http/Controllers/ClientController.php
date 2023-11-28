<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Client;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Client::class, 'client');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('clients.index', [
            'items' => Client::search($request->input('query') ?? '')->paginate(10),
            'resourceName' => 'clients',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'vat' => ['required', 'integer', 'between:1000,99999'],
            'street_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'regex:/^\d{5}(-\d{4})?$/'],
        ]);

        $address = Address::create([
            'street_address' => $request->street_address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
        ]);

        Client::create([
            'company' => $request->company,
            'vat' => $request->vat,
            'address_id' => $address->id,
        ]);

        return redirect('/clients');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('clients.show', [
            'client' => $client
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', [
            'client' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'company' => ['exclude_if:company,' . $client->company, 'required', 'string', 'max:255'],
            'vat' => ['exclude_if:vat,' . $client->vat, 'required', 'integer', 'between:1000,99999'],
            'street_address' => ['exclude_if:street_address,' . $client->address->street_address, 'required', 'string', 'max:255'],
            'city' => ['exclude_if:city,' . $client->address->city, 'required', 'string', 'max:255'],
            'state' => ['exclude_if:state,' . $client->address->state, 'required', 'string', 'max:255'],
            'zip_code' => ['exclude_if:zip_code,' . $client->address->zip_code, 'required', 'string', 'regex:/^\d{5}(-\d{4})?$/'],
        ]);

        foreach (['street_address', 'city', 'state', 'zip_code'] as $addressProp) {
            if (isset($validated[$addressProp])) {
                $client->address->update([$addressProp => $validated[$addressProp]]);
            }
        }

        foreach (['company', 'vat'] as $addressProp) {
            if (isset($validated[$addressProp])) {
                $client->update([$addressProp => $validated[$addressProp]]);
            }
        }


        return redirect('/clients');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        $client->address->delete();

        return redirect('/clients');
    }
}
