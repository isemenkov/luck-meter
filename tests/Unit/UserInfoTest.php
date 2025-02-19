<?php

namespace Tests\Unit;

use App\Services\UserInfoService;
use PHPUnit\Framework\TestCase;
use App\Interfaces\AccessTokenRepository;
use App\Objects\User;
use App\Statuses\UserInfoStatus;

final class UserInfoTest extends TestCase
{
    public function testGetUserInfoSuccess(): void
    {
        $repository = $this->createMock(AccessTokenRepository::class);
        $repository->expects($this->once())
            ->method('getUserData')
            ->willReturn(new User('test', '+1 234 567 8901'));

        $userInfoService = new UserInfoService($repository);
        $info = $userInfoService->getUserData('test_token_1');

        $this->assertInstanceOf(User::class, $info);
        $this->assertEquals('test', $info->name);
        $this->assertEquals('+1 234 567 8901', $info->phone);
    }

    public function testGetUserInfoFail(): void
    {
        $repository = $this->createMock(AccessTokenRepository::class);
        $repository->expects($this->once())
            ->method('getUserData')
            ->willReturn(UserInfoStatus::ACCESS_TOKEN_NOT_VALID);

        $userInfoService = new UserInfoService($repository);
        $info = $userInfoService->getUserData('test_token_1');

        $this->assertEquals(UserInfoStatus::ACCESS_TOKEN_NOT_VALID, $info);
    }
}
