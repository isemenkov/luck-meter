<?php

namespace Tests\Unit\Repositories;

use App\Models\ScoreResult;
use Database\Seeders\ScoreResultSeeder;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Statuses\LuckResultStatus;

final class ScoreResultRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private const PHONE_NUMBER = '+1 234 567 8901';

    public function testSaveResultSuccess(): void
    {
        $this->assertDatabaseEmpty('score_results');

        (new ScoreResult())->saveResult(
            self::PHONE_NUMBER,
            LuckResultStatus::WIN->value,
            500
        );

        $this->assertDatabaseCount('score_results', 1);
    }

    public function testSaveMultipleResultsSuccess(): void
    {
        $this->assertDatabaseEmpty('score_results');

        (new ScoreResult())->saveResult(
            self::PHONE_NUMBER,
            LuckResultStatus::WIN->value,
            500
        );

        (new ScoreResult())->saveResult(
            self::PHONE_NUMBER,
            LuckResultStatus::LOSE->value,
            0
        );

        $this->assertDatabaseCount('score_results', 2);
    }

    public function testGetResultsSuccess(): void
    {
        $this->seed(ScoreResultSeeder::class);

        $results = (new ScoreResult())->getResults(self::PHONE_NUMBER, 3);

        $this->assertCount(3, $results);
    }
}
