<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateRoleTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_role_should_not_be_shown_if_not_authenticated(): void
    {
        $response = $this->postJson("/api/roles", [
            'name' => '12345',
        ]);

        $response->assertStatus(404);
    }

    public function test_create_role_should_not_be_shown_if_not_authorized(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);

        $response = $this->postJson("/api/roles", [
            'name' => '12345',
        ]);

        $response->assertStatus(404);
    }

    public function test_create_role_should_show_with_permission(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $response = $this->postJson("/api/roles", [
            'name' => '12345',
        ]);

        $response->assertStatus(201);
    }
}
