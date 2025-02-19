<?php

namespace App\Statuses;

enum AccessTokenSaveStatus: string
{
    case SUCCESS = 'success';
    case ALREADY_EXISTS = 'already_exists';
}
