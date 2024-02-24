<?php

namespace App\Policies;

use App\Enums\CompanyPermissions;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(CompanyPermissions::READ->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Company $company): bool
    {
        return $user->can(CompanyPermissions::READ->value) && $user->organizations->contains($company->organization_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(CompanyPermissions::CREATE->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Company $company): bool
    {
        return $user->can(CompanyPermissions::UPDATE->value) && $user->organizations->contains($company->organization_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Company $company): bool
    {
        return $user->can(CompanyPermissions::DELETE->value) && $user->organizations->contains($company->organization_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Company $company): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Company $company): bool
    {
        return false;
    }

    /**
     * Perform pre-authorization checks on the model.
    */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('owner')) {
            return true;
        }

        return null; // see the note above in Gate::before about why null must be returned here.
    }
}
