<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class HomePageTest extends TestCase
{
    public function testHomePageRedirectSuccess(): void
    {
        $response = $this->get('/');

        $response->assertRedirectToRoute('register_form');
    }
}
