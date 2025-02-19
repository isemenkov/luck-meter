<?php

namespace App\Services;

use App\Interfaces\AccessTokenGenerator;
use Illuminate\Support\Str;

final readonly class AccessTokenGeneratorService implements AccessTokenGenerator
{
    public function generate(): string
    {
        return Str::random(100);
    }
}
