<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login(): void
    {
        $response = $this->postJson("/api/login", [
            'email' => 'admin@example.com',
            'password' => 'secret1234',
        ]);

        $response->assertStatus(200);
    }
}
