<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;

class GetPermissionOfRoleTest extends TestCase
{
    public function test_get_permissions_of_role_should_not_be_shown_if_not_authenticated(): void
    {
        $response = $this->get('/api/roles/1/permissions');

        $response->assertStatus(404);
    }

    public function test_get_permissions_of_role_should_not_be_shown_if_not_authorized(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);

        $response = $this->get('/api/roles/1/permissions');

        $response->assertStatus(404);
    }

    public function test_get_permissions_of_role_should_be_shown_if_owned(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);

        $response = $this->get('/api/roles/4/permissions');

        $response->assertStatus(200);
    }
    
    public function test_get_permissions_of_role_should_show_with_permission(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $response = $this->get('/api/roles/4/permissions');

        $response->assertStatus(200);
    }
}
