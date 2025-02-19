<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class RegisterFormTest extends TestCase
{
    public function testRenderSuccess(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);

        $response->assertSee('Register');
        $response->assertSee('Username');
        $response->assertSee('Phone Number');
    }

    public function testRenderDontSeeValidationErrorsSuccess(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);

        $response->assertDontSee('The username field must');
        $response->assertDontSee('The phonenumber must');
    }

    public function testRenderSeeValidationErrorsSuccess(): void
    {
        $view = $this->withViewErrors([
            'username' => 'The username field must only contain letters and numbers.',
            'phonenumber' => 'The phonenumber must be a valid phone number format.',
        ])->view('register');

        $view->assertSee('The username field must only contain letters and numbers.');
        $view->assertSee('The phonenumber must be a valid phone number format.');
    }
}
