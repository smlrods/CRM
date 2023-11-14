<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum ClientPermissionsEnum: string
{
    use ToArrayEnum;

    case READ_CLIENTS = 'read-clients';
    case CREATE_CLIENTS = 'create-clients';
    case UPDATE_CLIENTS = 'update-clients';
    case DELETE_CLIENTS = 'delete-clients';
}
