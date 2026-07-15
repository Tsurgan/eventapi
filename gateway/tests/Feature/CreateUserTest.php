<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateUserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_user_with_valid_should_be_valid(): void
    {
        $response = $this->postJson("/api/register", [
            'name' => '12345',
            'email' => 'example@example.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ]);

        $response->assertStatus(201);
    }
}
