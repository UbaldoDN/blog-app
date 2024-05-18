<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Services\Auth\AuthorAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Tests\TestCase;

class AuthorAuthControllerTest extends TestCase
{
    public function test_admin_login()
    {
        $response = $this->postJson('/api/v1/authors/login', [
            'email'    => 'author@example.com',
            'password' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
                'data'   => [
                    'id'    => 2,
                    'name'  => 'Author',
                    'email' => 'author@example.com',
                    'role'  => 'author',
                ],
            ]);
    }

    public function test_admin_logout()
    {
        (new AuthorAuthService(new SessionRepository))->login(2, 'Author', 'author@example.com');
        $response = $this->postJson('/api/v1/authors/logout');
        $response->assertStatus(204);
    }
}
