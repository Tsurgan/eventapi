<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;

class GetUserByIdTest extends TestCase
{
    public function test_get_user_should_not_be_shown_if_not_authenticated(): void
    {
        $response = $this->get('/api/user/1');

        $response->assertStatus(404);
    }
    public function test_get_user_should_not_be_shown_if_not_authorized_or_own(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);

        $firstResponse = $this->get('/api/users/1');

        $firstResponse->assertStatus(404);
        $secondResponse = $this->get('/api/users/4');

        $secondResponse->assertStatus(200);
    }
    public function test_get_user_should_show_with_permission(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $response = $this->get('/api/users/4');

        $response->assertStatus(200);
    }
}
