<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum LeadPermissions: string
{
    use ToArrayEnum;

    case READ = 'read-leads';
    case CREATE = 'create-leads';
    case UPDATE = 'update-leads';
    case DELETE = 'delete-leads';

    public function label(): string
    {
        return match ($this) {
            static::READ => 'Read Leads',
            static::CREATE => 'Create Leads',
            static::UPDATE => 'Update Leads',
            static::DELETE => 'Delete Leads',
        };
    }
}
