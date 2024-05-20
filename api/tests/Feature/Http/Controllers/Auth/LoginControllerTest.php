<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login()
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email'    => 'admin@example.com',
            'password' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
                'data'   => [
                    'user' => [
                        'email' => 'admin@example.com',
                        'role'  => 'admin',
                    ]
                ],
            ]);
    }

    public function test_login_logout()
    {
        $user = User::factory()->create([
            'email' => 'author@example.com',
            'role' => 'author'
        ]);

        Sanctum::actingAs($user);
        $response = $this->postJson('/api/v1/logout');
        $response->assertStatus(200);
    } 
}
