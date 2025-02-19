<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\AccessTokenRepository;
use App\Interfaces\AccessTokenGenerator;
use App\Interfaces\ResultsRepository;
use App\Models\AccessToken;
use App\Models\ScoreResult;
use App\Services\AccessTokenGeneratorService;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AccessTokenRepository::class,
            AccessToken::class
        );

        $this->app->bind(
            AccessTokenGenerator::class,
            AccessTokenGeneratorService::class
        );

        $this->app->bind(
            ResultsRepository::class,
            ScoreResult::class
        );
    }

    public function boot(): void
    {
    }
}
