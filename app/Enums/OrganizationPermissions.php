<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum OrganizationPermissions: string
{
    use ToArrayEnum;

    case READ = 'read-organizations';
    case CREATE = 'create-organizations';
    case UPDATE = 'update-organizations';
    case DELETE = 'delete-organizations';
}
