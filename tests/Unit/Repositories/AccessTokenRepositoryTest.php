<?php

namespace Tests\Unit\Repositories;

use App\Objects\User;
use App\Statuses\AccessTokenStatus;
use App\Statuses\AccessTokenUpdateStatus;
use App\Statuses\UserInfoStatus;
use Database\Seeders\AccessTokenSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use App\Models\AccessToken;
use App\Statuses\AccessTokenSaveStatus;

final class AccessTokenRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private const USER_NAME = 'test';
    private const PHONE_NUMBER = '+1 234 567 8901';
    private const NEW_ACCESS_TOKEN = '94df87efeaf85d29bf12385c354f1d3f';
    private const NOT_VALID_ACCESS_TOKEN = '80243ac57c23d529193b5fbff8a58a30';

    private const EXISTS_USER_NAME = 'user';
    private const EXISTS_USER_PHONE = '+44 20 1234 5678';
    private const EXISTS_ACCESS_TOKEN = 'e6fee5e2fc738d7c7ed4f7cf8b4c351b';

    public function testSaveNewAccessTokenSuccess(): void
    {
        $this->assertDatabaseEmpty('access_tokens');

        $result = (new AccessToken())->saveToken(
            self::USER_NAME,
            self::PHONE_NUMBER,
            self::NEW_ACCESS_TOKEN
        );

        $this->assertEquals(AccessTokenSaveStatus::SUCCESS, $result);
        $this->assertDatabaseCount('access_tokens', 1);
    }

    public function testSaveAlreadyExistsAccessTokenFail(): void
    {
        $this->seed(AccessTokenSeeder::class);

        $this->assertDatabaseCount('access_tokens', 2);

        $result = (new AccessToken())->saveToken(
            self::USER_NAME,
            self::PHONE_NUMBER,
            self::EXISTS_ACCESS_TOKEN
        );

        $this->assertEquals(AccessTokenSaveStatus::ALREADY_EXISTS, $result);
        $this->assertDatabaseCount('access_tokens', 2);
    }

    public function testChangeStatusSuccess(): void
    {
        $this->seed(AccessTokenSeeder::class);

        $result = (new AccessToken())->changeStatus(
            self::EXISTS_ACCESS_TOKEN,
            AccessTokenStatus::INACTIVE
        );

        $this->assertEquals(AccessTokenUpdateStatus::SUCCESS, $result);
    }

    public function testChangeStatusFail(): void
    {
        $result = (new AccessToken())->changeStatus(
            self::NEW_ACCESS_TOKEN,
            AccessTokenStatus::INACTIVE
        );

        $this->assertEquals(AccessTokenUpdateStatus::TOKEN_DOESNT_EXIST, $result);
    }

    public function testIsValidSuccess(): void
    {
        $this->seed(AccessTokenSeeder::class);

        $this->assertTrue((new AccessToken())->isValid(self::EXISTS_ACCESS_TOKEN));
    }

    public function testIsValidFail(): void
    {
        $this->seed(AccessTokenSeeder::class);

        $this->assertFalse((new AccessToken())->isValid(self::NOT_VALID_ACCESS_TOKEN));
    }

    public function testIsValidNotExistsTokenFail(): void
    {
        $this->assertFalse((new AccessToken())->isValid(self::NEW_ACCESS_TOKEN));
    }

    public function testGetUserDataSuccess(): void
    {
        $this->seed(AccessTokenSeeder::class);

        $result = (new AccessToken())->getUserData(self::EXISTS_ACCESS_TOKEN);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals(self::EXISTS_USER_NAME, $result->name);
        $this->assertEquals(self::EXISTS_USER_PHONE, $result->phone);
    }

    public function testGetUserDataFail(): void
    {
        $result = (new AccessToken())->getUserData(self::NEW_ACCESS_TOKEN);

        $this->assertEquals(UserInfoStatus::ACCESS_TOKEN_NOT_VALID, $result);
    }
}
