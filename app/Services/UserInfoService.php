<?php

namespace App\Services;

use App\Interfaces\AccessTokenRepository;
use App\Statuses\UserInfoStatus;
use App\Objects\User;

final readonly class UserInfoService
{
    public function __construct(
        private AccessTokenRepository $repository,
    ) {
    }

    public function getUserData(string $accessToken): User|UserInfoStatus
    {
        return $this->repository->getUserData($accessToken);
    }
}
