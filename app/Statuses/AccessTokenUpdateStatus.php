<?php

namespace App\Statuses;

enum AccessTokenUpdateStatus: string
{
    case SUCCESS = 'success';
    case TOKEN_DOESNT_EXIST = 'token_doesnt_exist';
}
