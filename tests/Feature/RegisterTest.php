<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterSuccess(): void
    {
        $response = $this->post('/register', [
            'username' => 'test',
            'phonenumber' => '+1 234 567 8901',
        ]);

        $response->assertRedirectContains('/lucky');
    }

    public function testRegisterFail(): void
    {
        $response = $this->post('/register', [
            'username' => 'test',
            'phonenumber' => 'test',
        ]);

        $response->assertRedirect('/register');
    }
}
