<?php

namespace Tests\Feature;

use App\Objects\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;
use App\Interfaces\AccessTokenRepository;

final class ResultHistoryTest extends TestCase
{
    private const ACCESS_TOKEN = 'rut8zMoHqTOalcB9NHmdqFXlupDGVcLLse9MByuV6fOh3mXksY8gnKWjjyfOi3KysS9sxiOypAHJyLwYTVN3EDlqEKPL6fR5oHwn';

    public function testGetResultHistoryEmptySuccess(): void
    {
        $this->app->instance(
            AccessTokenRepository::class,
            Mockery::mock(AccessTokenRepository::class, function (Mockery\MockInterface $mock) {
                $mock->shouldReceive('isValid')->andReturn(true);
                $mock->shouldReceive('getUserData')->andReturn(new User('test', '+1 234 567 8901'));
            })
        );

        $routeUrl = route('last-results');
        $response = $this->withSession(['access_token' => self::ACCESS_TOKEN])->post($routeUrl);

        $response->assertRedirectToRoute('lucky_form');
    }
}
