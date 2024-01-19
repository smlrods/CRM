<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum MemberPermissions: string
{
    use ToArrayEnum;

    case READ = 'read-members';
    case CREATE = 'create-members';
    case UPDATE = 'update-members';
    case DELETE = 'delete-members';

    public function label(): string
    {
        return match ($this) {
            static::READ => 'Read Members',
            static::CREATE => 'Create Members',
            static::UPDATE => 'Update Members',
            static::DELETE => 'Delete Members',
        };
    }
}
