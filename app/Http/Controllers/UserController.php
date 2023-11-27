<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Enums\UserPermissionsEnum;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('users.index', [
            'items' => User::search($request->input('query') ?? '')->paginate(10),
            'resourceName' => 'users',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => [Rule::enum(RolesEnum::class), 'required'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole($request->role);

        return redirect('/users');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => [Rule::excludeIf($request->input('name') === $user->name), 'required', 'string', 'max:255'],
            'email' => [Rule::excludeIf($request->input('email') === $user->email), 'required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => [Rule::excludeIf(! $request->filled('password')), 'confirmed', Rules\Password::defaults()],
            'role' => [Rule::enum(RolesEnum::class), [Rule::excludeIf($request->input('role') === $user->roles->first()->name)], 'required'],
        ]);

        if (! empty($validated)) {
            $user->update($validated);
            if ($validated['role']) {
                $user->syncRoles($validated['role']);
            }
        }

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/users');
    }
}
