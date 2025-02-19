<?php

namespace App\Objects;

use App\Statuses\LuckResultStatus;

final readonly class LuckResult
{
    public function __construct(
        public LuckResultStatus $result,
        public int $score,
    ) {
    }
}
