<?php

namespace App\Services;

use App\Interfaces\ResultsRepository;

final readonly class ResultsService
{
    public function __construct(
        private ResultsRepository $repository
    ) {
    }

    public function saveResult(string $phoneNumber, string $result, int $score): void
    {
        $this->repository->saveResult($phoneNumber, $result, $score);
    }

    public function getResults(string $phoneNumber, int $limit): array
    {
        return $this->repository->getResults($phoneNumber, $limit);
    }
}
