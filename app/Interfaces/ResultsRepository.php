<?php

namespace App\Interfaces;

interface ResultsRepository
{
    public const HISTORY_RESULTS_LIMIT = 3;

    public function saveResult(string $phoneNumber, string $result, int $score): void;
    public function getResults(string $phoneNumber, int $limit): array;
}
