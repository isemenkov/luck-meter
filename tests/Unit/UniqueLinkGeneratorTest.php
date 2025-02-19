<?php

namespace Tests\Unit;

use App\Interfaces\AccessTokenGenerator;
use App\Statuses\AccessTokenUpdateStatus;
use PHPUnit\Framework\TestCase;
use App\Interfaces\AccessTokenRepository;
use App\Services\UniqueLinkGeneratorService;
use App\Statuses\AccessTokenSaveStatus;

final class UniqueLinkGeneratorTest extends TestCase
{
    public function testGenerateLinkSuccess(): void
    {
        $repository = $this->createMock(AccessTokenRepository::class);
        $repository->expects($this->once())
            ->method('saveToken')
            ->willReturn(AccessTokenSaveStatus::SUCCESS);

        $generator = $this->createMock(AccessTokenGenerator::class);
        $generator->expects($this->once())
            ->method('generate')
            ->willReturn('test_token_1');

        $uniqueLinkService = new UniqueLinkGeneratorService($repository, $generator);
        $accessToken = $uniqueLinkService->generate('test', '+1 234 567 8901');

        $this->assertIsString($accessToken);
        $this->assertEquals('test_token_1', $accessToken);
    }

    public function testGenerateLinkWithOneCollision(): void
    {
        $repository = $this->createMock(AccessTokenRepository::class);
        $repository->expects($this->exactly(2))
            ->method('saveToken')
            ->willReturnOnConsecutiveCalls(
                AccessTokenSaveStatus::ALREADY_EXISTS,
                AccessTokenSaveStatus::SUCCESS,
            );

        $generator = $this->createMock(AccessTokenGenerator::class);
        $generator->expects($this->exactly(2))
            ->method('generate')
            ->willReturnOnConsecutiveCalls(
                'test_token_1',
                'test_token_2',
            );

        $uniqueLinkService = new UniqueLinkGeneratorService($repository, $generator);
        $accessToken = $uniqueLinkService->generate('test', '+1 234 567 8901');

        $this->assertIsString($accessToken);
        $this->assertEquals('test_token_2', $accessToken);
    }

    public function testGenerateLinkWithMultipleCollisions(): void
    {
        $repository = $this->createMock(AccessTokenRepository::class);
        $repository->expects($this->exactly(3))
            ->method('saveToken')
            ->willReturnOnConsecutiveCalls(
                AccessTokenSaveStatus::ALREADY_EXISTS,
                AccessTokenSaveStatus::ALREADY_EXISTS,
                AccessTokenSaveStatus::SUCCESS,
            );

        $generator = $this->createMock(AccessTokenGenerator::class);
        $generator->expects($this->exactly(3))
            ->method('generate')
            ->willReturnOnConsecutiveCalls(
                'test_token_1',
                'test_token_2',
                'test_token_3',
            );

        $uniqueLinkService = new UniqueLinkGeneratorService($repository, $generator);
        $accessToken = $uniqueLinkService->generate('test', '+1 234 567 8901');

        $this->assertIsString($accessToken);
        $this->assertEquals('test_token_3', $accessToken);
    }

    public function testDeactivateAccessTokenSuccess(): void
    {
        $repository = $this->createMock(AccessTokenRepository::class);
        $repository->expects($this->once())
            ->method('changeStatus')
            ->willReturn(AccessTokenUpdateStatus::SUCCESS);

        $uniqueLinkService = new UniqueLinkGeneratorService($repository, $this->createMock(AccessTokenGenerator::class));
        $result = $uniqueLinkService->deactivateAccessToken('test_token_1');

        $this->assertEquals($result, AccessTokenUpdateStatus::SUCCESS);
    }

    public function testDeactivateAccessTokenFailure(): void
    {
        $repository = $this->createMock(AccessTokenRepository::class);
        $repository->expects($this->once())
            ->method('changeStatus')
            ->willReturn(AccessTokenUpdateStatus::TOKEN_DOESNT_EXIST);

        $uniqueLinkService = new UniqueLinkGeneratorService($repository, $this->createMock(AccessTokenGenerator::class));
        $result = $uniqueLinkService->deactivateAccessToken('test_token_1');

        $this->assertEquals($result, AccessTokenUpdateStatus::TOKEN_DOESNT_EXIST);
    }
}
