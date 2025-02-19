<?php

namespace App\Interfaces;

use App\Statuses\AccessTokenSaveStatus;
use App\Statuses\AccessTokenUpdateStatus;
use App\Statuses\AccessTokenStatus;
use App\Statuses\UserInfoStatus;
use App\Objects\User;

interface AccessTokenRepository
{
    public const VALID_TOKEN_TIME = 3600 * 24 * 7;

    public function getUserData(string $accessToken): User|UserInfoStatus;
    public function saveToken(string $userName, string $phoneNumber, string $accessToken): AccessTokenSaveStatus;
    public function changeStatus(string $accessToken, AccessTokenStatus $status): AccessTokenUpdateStatus;
    public function isValid(string $accessToken): bool;
}
