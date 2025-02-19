<?php

namespace App\Objects;

final readonly class User
{
    public function __construct(
        public string $name,
        public string $phone
    ) {
    }
}
