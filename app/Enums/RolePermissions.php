<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum RolePermissions: string
{
    use ToArrayEnum;

    case READ = 'read-roles';
    case CREATE = 'create-roles';
    case UPDATE = 'update-roles';
    case DELETE = 'delete-roles';

    public function label(): string
    {
        return match ($this) {
            static::READ => 'Read Roles',
            static::CREATE => 'Create Roles',
            static::UPDATE => 'Update Roles',
            static::DELETE => 'Delete Roles',
        };
    }
}
