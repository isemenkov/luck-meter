<?php

namespace Tests\Feature;

use App\Interfaces\AccessTokenRepository;
use App\Objects\User;
use App\Statuses\AccessTokenSaveStatus;
use App\Statuses\AccessTokenUpdateStatus;
use App\Statuses\UserInfoStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use Mockery;

final class ManageLinkTest extends TestCase
{
    private const ACCESS_TOKEN = 'rut8zMoHqTOalcB9NHmdqFXlupDGVcLLse9MByuV6fOh3mXksY8gnKWjjyfOi3KysS9sxiOypAHJyLwYTVN3EDlqEKPL6fR5oHwn';

    public function testGenerateNewLinkSuccess(): void
    {
        $this->app->instance(
            AccessTokenRepository::class,
            Mockery::mock(AccessTokenRepository::class, function (Mockery\MockInterface $mock) {
                $mock->shouldReceive('isValid')->andReturn(true);
                $mock->shouldReceive('getUserData')->andReturn(new User('test', '+1 234 567 8901'));
                $mock->shouldReceive('saveToken')->andReturn(AccessTokenSaveStatus::SUCCESS);
            })
        );

        $response = $this->withSession(['access_token' => self::ACCESS_TOKEN])->post('/manage-link', ['generateNewLink' => true]);

        $response->assertRedirectToRoute('lucky_form');
    }

    public function testGenerateNewLinkNotValidUserDataFail(): void
    {
        $this->app->instance(
            AccessTokenRepository::class,
            Mockery::mock(AccessTokenRepository::class, function (Mockery\MockInterface $mock) {
                $mock->shouldReceive('isValid')->andReturn(true);
                $mock->shouldReceive('getUserData')->andReturn(UserInfoStatus::ACCESS_TOKEN_NOT_VALID);
            })
        );

        $response = $this->withSession(['access_token' => self::ACCESS_TOKEN])->post('/manage-link', ['generateNewLink' => true]);

        $response->assertRedirectToRoute('register_form');
    }

    public function testDeactivateCurrentLinkSuccess(): void
    {
        $this->app->instance(
            AccessTokenRepository::class,
            Mockery::mock(AccessTokenRepository::class, function (Mockery\MockInterface $mock) {
                $mock->shouldReceive('isValid')->andReturn(true);
                $mock->shouldReceive('changeStatus')->andReturn(AccessTokenUpdateStatus::SUCCESS);
            })
        );

        $response = $this->withSession(['access_token' => self::ACCESS_TOKEN])->post('/manage-link', ['deactivateCurrentLink' => true]);

        $response->assertRedirectToRoute('register_form');
    }

    public function testManageLinkDefaultSuccess(): void
    {
        $this->app->instance(
            AccessTokenRepository::class,
            Mockery::mock(AccessTokenRepository::class, function (Mockery\MockInterface $mock) {
                $mock->shouldReceive('isValid')->andReturn(true);
            })
        );

        $routeUrl = route('manage-link', ['access_token' => self::ACCESS_TOKEN]);
        $response = $this->withSession(['access_token' => self::ACCESS_TOKEN])->post($routeUrl);

        $response->assertRedirectToRoute('lucky_form');
    }
}
