<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum ActivityPermissions: string
{
    use ToArrayEnum;

    case READ = 'read-activities';
    case CREATE = 'create-activities';
    case UPDATE = 'update-activities';
    case DELETE = 'delete-activities';

    public function label(): string
    {
        return match ($this) {
            static::READ => 'Read Activities',
            static::CREATE => 'Create Activities',
            static::UPDATE => 'Update Activities',
            static::DELETE => 'Delete Activities',
        };
    }
}
