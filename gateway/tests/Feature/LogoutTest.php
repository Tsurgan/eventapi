<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::find(4);
        Passport::actingAs($user);
        $response = $this->post('/api/logout');

        $response->assertStatus(204);
    }
}
