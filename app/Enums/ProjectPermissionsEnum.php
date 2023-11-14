<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum ProjectPermissionsEnum: string
{
    use ToArrayEnum;

    case READ_PROJECTS = 'read-projects';
    case CREATE_PROJECTS = 'create-projects';
    case EDIT_PROJECTS = 'edit-projects';
    case UPDATE_PROJECTS = 'update-projects';
    case DELETE_PROJECTS = 'delete-projects';
}
