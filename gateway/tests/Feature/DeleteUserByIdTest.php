<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class DeleteUserByIdTest extends TestCase
{
    use DatabaseTransactions;

    public function test_delete_users_should_not_be_shown_if_not_authenticated(): void
    {
        $response = $this->delete('/api/users/4');

        $response->assertStatus(404);
    }

    public function test_delete_users_should_not_be_shown_if_not_authorized(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);

        $response = $this->delete('/api/users/1');

        $response->assertStatus(404);
    }

    public function test_delete_users_should_be_shown_if_own(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);
        $response = $this->delete('/api/users/4');

        $response->assertStatus(204);
    }
    
    public function test_delete_users_should_show_with_permission(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $response = $this->delete('/api/users/3');

        $response->assertStatus(204);
    }

    public function test_delete_users_should_not_work_if_deleting_last_create_perm_user(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $response = $this->delete('/api/users/1');

        $response->assertStatus(403);
    }
}
