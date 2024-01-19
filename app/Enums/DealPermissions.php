<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum DealPermissions: string
{
    use ToArrayEnum;

    case READ = 'read-deals';
    case CREATE = 'create-deals';
    case UPDATE = 'update-deals';
    case DELETE = 'delete-deals';

    public function label(): string
    {
        return match ($this) {
            static::READ => 'Read Deals',
            static::CREATE => 'Create Deals',
            static::UPDATE => 'Update Deals',
            static::DELETE => 'Delete Deals',
        };
    }
}
