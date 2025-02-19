<?php

namespace App\Statuses;

enum AccessTokenStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
