<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PutRoleByIdTest extends TestCase
{
    use DatabaseTransactions;

    public function test_put_role_should_not_work_if_not_authenticated(): void
    {
        $response = $this->putJson("/api/roles/1", [
            'name' => '12345',
        ]);
        $response->assertStatus(404);
    }
    
    public function test_put_role_should_not_work_if_not_authorized(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);

        $secondResponse = $this->putJson("/api/roles/1", [
            'name' => '12345',
        ]);

        $secondResponse->assertStatus(404);
    }

    public function test_put_role_should_work_with_permission(): void
    {
        $user = User::find(1);
        Passport::actingAs($user);
        $response = $this->putJson("/api/roles/1", [
            'name' => '12345',
            'is_default' => true,
        ]);

        $response->assertStatus(200);
    }

}
