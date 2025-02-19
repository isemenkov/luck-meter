<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use App\Services\LuckCalculator;
use App\Statuses\LuckResultStatus;
use App\Objects\LuckResult;

final class LuckCalculatorTest extends TestCase
{
    public static function provideWinningValues(): array
    {
        return [
            [2, 0],      // Edge case: minimum even number
            [100, 10],   // 10% of 100
            [298, 29],   // Edge case: last value before 300 threshold (10%)
            [302, 90],   // Edge case: first value at 30% threshold
            [350, 105],  // 30% of 350
            [598, 179],  // Edge case: last value before 600 threshold (30%)
            [602, 301],  // Edge case: first value at 50% threshold
            [650, 325],  // 50% of 650
            [898, 449],  // Edge case: last value before 900 threshold (50%)
            [902, 631],  // Edge case: first value at 70% threshold
            [950, 665],  // 70% of 950
            [1000, 700], // Edge case: high limit test (70%)
        ];
    }

    public function testCalculateReturnsWinForEvenNumbers(): void
    {
        $calculator = new LuckCalculator();
        $result = $calculator->calculate(200);

        $this->assertInstanceOf(LuckResult::class, $result);
        $this->assertEquals(LuckResultStatus::WIN, $result->result);
        $this->assertEquals(20, $result->score); // 10% of 200
    }

    public function testCalculateReturnsLoseForOddNumbers(): void
    {
        $calculator = new LuckCalculator();
        $result = $calculator->calculate(201);

        $this->assertInstanceOf(LuckResult::class, $result);
        $this->assertEquals(LuckResultStatus::LOSE, $result->result);
        $this->assertEquals(0, $result->score);
    }

    #[DataProvider('provideWinningValues')]
    public function testCalculateWinScore(int $value, int $expectedScore): void
    {
        $calculator = new LuckCalculator();
        $result = $calculator->calculate($value);
        $this->assertEquals(LuckResultStatus::WIN, $result->result);
        $this->assertEquals($expectedScore, $result->score);
    }

}
