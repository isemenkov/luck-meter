<?php

namespace App\Interfaces;

interface AccessTokenGenerator
{
    public function generate(): string;
}
