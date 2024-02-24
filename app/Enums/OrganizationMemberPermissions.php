<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum OrganizationMemberPermissions: string
{
    use ToArrayEnum;

    case READ = 'read-members';
    case CREATE = 'create-members';
    case UPDATE = 'update-members';
    case DELETE = 'delete-members';
}
