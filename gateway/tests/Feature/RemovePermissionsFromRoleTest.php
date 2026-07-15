<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RemovePermissionsFromRoleTest extends TestCase
{
    use DatabaseTransactions;

    public function test_remove_permissions_from_role_should_not_work_if_not_authenticated(): void
    {
        $response = $this->postJson("/api/roles/1/permission-deletions", [
            'permission_ids' => ['1','2'],
        ]);
        $response->assertStatus(404);
    }

    public function test_remove_permissions_from_role_should_not_work_if_not_authorized(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);

        $response = $this->postJson("/api/roles/4/permission-deletions", [
            'permission_ids' => ['1','2'],
        ]);

        $response->assertStatus(404);
    }
    
    public function test_remove_permission_from_role_should_work_with_permission(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);
        $response = $this->postJson("/api/roles/1/permission-deletions", [
            'permission_ids' => ['1','2'],
        ]);

        $response->assertStatus(200);
    }
}
