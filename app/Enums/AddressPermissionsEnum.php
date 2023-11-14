<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum AddressPermissionsEnum: string
{
    use ToArrayEnum;

    case READ_ADDRESSES = 'read-addresses';
    case CREATE_ADDRESSES = 'create-addresses';
    case UPDATE_ADDRESSES = 'update-addresses';
    case DELETE_ADDRESSES = 'delete-addresses';
}
