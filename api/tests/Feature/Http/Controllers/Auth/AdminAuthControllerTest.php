<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Services\Auth\AdminAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Tests\TestCase;

class AdminAuthControllerTest extends TestCase
{
    public function test_admin_login()
    {
        $response = $this->postJson('/api/v1/admin/login', [
            'email'    => 'admin@example.com',
            'password' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
                'data'   => [
                    'id'    => 1,
                    'name'  => 'Admin',
                    'email' => 'admin@example.com',
                    'role'  => 'admin',
                ],
            ]);
    }

    public function test_admin_logout()
    {
        (new AdminAuthService(new SessionRepository))->login(1, 'Admin', 'admin@example.com');
        $response = $this->postJson('/api/v1/admin/logout');
        $response->assertStatus(204);
    }
}
