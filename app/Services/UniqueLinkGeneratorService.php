<?php

namespace App\Services;

use App\Interfaces\AccessTokenGenerator;
use App\Interfaces\AccessTokenRepository;
use App\Statuses\AccessTokenSaveStatus;
use App\Statuses\AccessTokenStatus;
use App\Statuses\AccessTokenUpdateStatus;

final readonly class UniqueLinkGeneratorService
{
    public function __construct(
        private AccessTokenRepository $repository,
        private AccessTokenGenerator $generator,
    ) {
    }

    public function generate(string $username, string $phoneNumber): string
    {
        do {
            $accessToken = $this->generator->generate();
        } while ($this->repository->saveToken($username, $phoneNumber, $accessToken) === AccessTokenSaveStatus::ALREADY_EXISTS);

        return $accessToken;
    }

    public function deactivateAccessToken(string $accessToken): AccessTokenUpdateStatus
    {
        return $this->repository->changeStatus($accessToken, AccessTokenStatus::INACTIVE);
    }

    public function isValid(string $accessToken): bool
    {
        return $this->repository->isValid($accessToken);
    }
}
