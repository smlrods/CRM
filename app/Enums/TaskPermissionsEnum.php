<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum TaskPermissionsEnum: string
{
    use ToArrayEnum;

    case READ_TASKS = 'read-tasks';
    case CREATE_TASKS = 'create-tasks';
    case EDIT_TASKS = 'edit-tasks';
    case UPDATE_TASKS = 'update-tasks';
    case DELETE_TASKS = 'delete-tasks';
}
