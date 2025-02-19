<?php

namespace App\Services;

use App\Objects\LuckResult;
use App\Statuses\LuckResultStatus;

final readonly class LuckCalculator
{
    public function calculate(int $value): LuckResult
    {
        $result = $this->calculateResult($value);

        return new LuckResult(
            $result,
            $this->calculateScore($result, $value),
        );
    }

    private function calculateResult(int $value): LuckResultStatus
    {
        if ($value % 2 === 0) {
            return LuckResultStatus::WIN;
        }

        return LuckResultStatus::LOSE;
    }

    private function calculateScore(LuckResultStatus $result, int $value): int
    {
        return match ($result) {
            LuckResultStatus::WIN => $this->calculateWinScore($value),
            LuckResultStatus::LOSE => 0,
        };
    }

    private function calculateWinScore(int $value): int
    {
        return match(true) {
            $value > 900 => $this->calculatePercent($value, 70),
            $value > 600 => $this->calculatePercent($value, 50),
            $value > 300 => $this->calculatePercent($value, 30),
            default => $this->calculatePercent($value, 10),
        };
    }

    private function calculatePercent(int $value, int $percent): int
    {
        return (int)($value * $percent / 100);
    }
}
