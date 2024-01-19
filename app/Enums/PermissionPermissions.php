<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum PermissionPermissions: string
{
    use ToArrayEnum;

    case READ = 'read-permissions';
    case CREATE = 'create-permissions';
    case UPDATE = 'update-permissions';
    case DELETE = 'delete-permissions';
}
