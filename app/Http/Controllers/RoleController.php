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
}
