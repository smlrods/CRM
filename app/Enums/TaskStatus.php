<?php

namespace App\Enums;

use App\Enums\Traits\ToArrayEnum;

enum TaskStatus: string
{
    use ToArrayEnum;

    case NOTSTARTED = 'not started';
    case INPROGRESS = 'in progress';
    case ONHOLD = 'on hold';
    case COMPLETED = 'completed';
    case DELAYED = 'delayed';
    case BLOCKED = 'blocked';
    case CANCELLED = 'cancelled';
    case NEEDSREVIEW = 'needs review';
    case HIGHPRIORITY = 'high priority';
    case LOWPRIORITY = 'low priority';
}
