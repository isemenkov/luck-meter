<?php

namespace Tests\Unit;

use App\Statuses\LuckResultStatus;
use PHPUnit\Framework\TestCase;
use App\Interfaces\ResultsRepository;
use App\Services\ResultsService;

final class ResultsServiceTest extends TestCase
{
    private const PHONE_NUMBER = '+1 234 567 8901';

    public function testSaveResultSuccess(): void
    {
        $repository = $this->createMock(ResultsRepository::class);
        $repository->expects($this->once())
            ->method('saveResult');

        $service = new ResultsService($repository);
        $service->saveResult(self::PHONE_NUMBER, LuckResultStatus::WIN->value, 500);
    }

    public function testGetResultsSuccess(): void
    {
        $repository = $this->createMock(ResultsRepository::class);
        $repository->expects($this->once())
            ->method('getResults')
            ->willReturn([
                [sprintf('%s (%s points)', LuckResultStatus::WIN->value, 500)],
                [sprintf('%s (%s points)', LuckResultStatus::LOSE->value, 0)],
                [sprintf('%s (%s points)', LuckResultStatus::WIN->value, 154)],
            ]);

        $service = new ResultsService($repository);
        $results = $service->getResults(self::PHONE_NUMBER, 3);

        $this->assertCount(3, $results);
    }
}
