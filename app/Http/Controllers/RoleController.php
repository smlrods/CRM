<?php

namespace App\Http\Controllers;

use App\Enums\ActivityPermissions;
use App\Enums\AddressPermissionsEnum;
use App\Enums\CompanyPermissions;
use App\Enums\ContactPermissions;
use App\Enums\DealPermissions;
use App\Enums\LeadPermissions;
use App\Enums\MemberPermissions;
use App\Enums\RolePermissions;
use App\Http\Resources\RoleResource;
use App\Models\Address;
use App\Models\Organization;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organization = Organization::find(session('organization_id'));

        // Cache the permissions for 24 hours
        $permissions = Cache::remember('permissions', 60 * 60 * 24, function () {
            $permissionTypes = [
                'roles' => RolePermissions::class,
                'members' => MemberPermissions::class,
                'contacts' => ContactPermissions::class,
                'companies' => CompanyPermissions::class,
                'leads' => LeadPermissions::class,
                'deals' => DealPermissions::class,
                'activities' => ActivityPermissions::class,
            ];

            $allPermissions = Permission::all();

            $permissions = [];

            foreach ($permissionTypes as $type => $class) {
                // Filter the permissions in memory
                $permissions[$type] = $allPermissions->whereIn('name', $class::toArray())->map(function ($permission) use ($class) {
                    return [
                        'value' => $permission->id,
                        'label' => $class::from($permission->name)->label(),
                    ];
                });
            }

            return $permissions;
        });

        // If the user is searching for a role, return the search results.
        if (request()->input('query')) {
            $searchResults = Role::search(request()->input('query'))
                ->whereIn('id', $organization->roles->pluck('id')->toArray())
                ->paginate(10);

            return Inertia::render('Roles', [
                'pagination' => $searchResults,
                'permissions' => $permissions,
            ]);
        }

        $roles = $organization->roles()->with('permissions')->orderBy('name')->orderBy('id')->cursorPaginate(10);

        return Inertia::render('Roles', [
            'pagination' => $roles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'permissions' => ['required', 'array'],
            'permissions.*' => Rule::in(Permission::get()->pluck('id'))
        ]);

        $permissions = Permission::whereIn('id', $validated['permissions'])->get();

        Role::create([
            'name' => ucfirst($validated['name']),
            'guard_name' => 'web',
        ])->syncPermissions($permissions);

        return redirect()->back()->with(['message' => 'Role created successfully.', 'type' => 'success']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => [Rule::excludeIf($request->input('name') === $role->name), 'required', 'string', 'max:255', 'unique:roles'],
            'permissions' => ['required', 'array'],
            'permissions.*' => Rule::in(Permission::get()->pluck('id'))
        ]);

        $permissions = Permission::whereIn('id', $validated['permissions'])->get();

        if (array_key_exists('name', $validated)) {
            $role->update([
                'name' => ucfirst($validated['name']),
            ]);
        }

        $role->syncPermissions($permissions);

        return to_route('roles.index')->with(['message' => 'Role updated successfully.', 'type' => 'success']);
    }
}
