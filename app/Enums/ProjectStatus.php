<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum ProjectStatus: string
{
    use ToArrayEnum;

    case PROGRESS = 'in process';
    case COMPLETED = 'completed';
    case ONHOLD = 'on hold';
    case CANCELLED = 'cancelled';
    case PENDING = 'pending approval';
}
