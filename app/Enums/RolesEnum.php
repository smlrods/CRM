<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum RolesEnum: string
{
    use ToArrayEnum;

    case SUPER = 'super administrator';
    case ADMINISTRATOR = 'administrator';
    case SALES = 'sales-representative';
    case SUPPORT = 'customer-support';
    case MARKETING = 'marketing-professional';
    case ANALYST = 'analyst';

    public function label(): string
    {
        return match ($this) {
            static::SUPER => 'Super Administrators',
            static::ADMINISTRATOR => 'Administrators',
            static::SALES => 'Sales Representatives',
            static::SUPPORT => 'Customer Supports',
            static::MARKETING => 'Marketing Professionals',
            static::ANALYST => 'Analysts',
        };
    }
}
