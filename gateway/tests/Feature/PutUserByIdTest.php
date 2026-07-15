<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PutUserByIdTest extends TestCase
{
    use DatabaseTransactions;

    public function test_put_user_should_not_work_if_not_authenticated(): void
    {
        $response = $this->putJson("/api/users/1", [
            'name' => '12345',
        ]);
        $response->assertStatus(404);
    }
    
    public function test_put_users_should_not_work_if_not_authorized(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);

        $response = $this->putJson("/api/users/3", [
            'name' => '12345',
        ]);

        $response->assertStatus(404);
    }

    public function test_put_users_should_work_if_own_if_not_related_to_perms(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);

        $response = $this->putJson("/api/users/4", [
            'name' => '12345',
        ]);

        $response->assertStatus(200);
    }

    public function test_put_users_should_not_work_if_adds_perms_without_perm(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);

        $response = $this->putJson("/api/users/4", [
            'role_id' => '1',
        ]);

        $response->assertStatus(404);
    }

    public function test_put_users_should_not_work_if_removes_perms_without_perm(): void
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $response = $this->putJson("/api/users/2", [
            'role_id' => '4',
        ]);

        $response->assertStatus(404);
    }

    public function test_put_users_should_remove_perms_when_permitted(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $response = $this->putJson("/api/users/2", [
            'role_id' => '4',
        ]);

        $response->assertStatus(200);
    }

    public function test_put_users_should_add_perms_when_permitted(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $response = $this->putJson("/api/users/4", [
            'role_id' => '2',
        ]);

        $response->assertStatus(200);
    }
    
    public function test_put_users_should_work_with_permission(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);
        $response = $this->putJson("/api/users/4", [
            'name' => '12345',
        ]);

        $response->assertStatus(200);
    }

    public function test_put_user_fields(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);
        $firstResponse = $this->putJson("/api/users/4", [
            'name' => '12345',
            'email' => 'example1@example.com',
            'phone' => '98888888888',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $firstResponse->assertStatus(200);

        $secondResponse = $this->putJson("/api/users/4", [
            'role_id' => '2',
        ]);

        $secondResponse->assertStatus(200);
    }
   public function test_put_user_should_not_change_role_if_last_create_perm_would_be_deleted(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $response = $this->putJson("/api/users/1", [
            'role_id' => '4',
        ]);

        $response->assertStatus(403);
    }
}
