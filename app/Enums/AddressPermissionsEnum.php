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

    public function label(): string
    {
        return match ($this) {
            static::READ_ADDRESSES => 'Read Addresses',
            static::CREATE_ADDRESSES => 'Create Addresses',
            static::UPDATE_ADDRESSES => 'Update Addresses',
            static::DELETE_ADDRESSES => 'Delete Addresses',
        };
    }
}
