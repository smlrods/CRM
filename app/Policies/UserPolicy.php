<?php

namespace App\Policies;

use App\Enums\RolesEnum;
use App\Enums\UserPermissionsEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     * @param \App\Models\User|null $User
     * @param \App\Post $post
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can(UserPermissionsEnum::READ_USERS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can(UserPermissionsEnum::READ_USERS->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(UserPermissionsEnum::CREATE_USERS->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        //
        return $user->can(UserPermissionsEnum::UPDATE_USERS->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->can(UserPermissionsEnum::DELETE_USERS->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Perform pre-authorization checks on the model
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole(RolesEnum::SUPER->value)) {
            return true;
        }

        return null;
    }
}
