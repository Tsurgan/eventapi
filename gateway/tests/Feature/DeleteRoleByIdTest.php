<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteRoleByIdTest extends TestCase
{
    use DatabaseTransactions;

    public function test_delete_roles_should_not_be_shown_if_not_authenticated(): void
    {
        $response = $this->delete('/api/roles/4');

        $response->assertStatus(404);
    }

    public function test_delete_roles_should_not_be_shown_if_not_authorized(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);

        $response = $this->delete('/api/roles/1');

        $response->assertStatus(404);
    }

    public function test_delete_roles_should_throw_error_if_attached_users_remain(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $response = $this->delete('/api/roles/4');

        $response->assertStatus(409);
    }
    
    public function test_delete_roles_should_show_with_permission(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $inputResponse = $this->postJson("/api/roles", [
            'name' => '12345',
        ]);
        
        $response = $this->delete('/api/roles/'.$inputResponse->json()['data']['id']);

        $response->assertStatus(204);
    }
}
