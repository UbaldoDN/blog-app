<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use App\Services\Auth\AdminAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class StoreAuthorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (new AdminAuthService(new SessionRepository))->login(1, 'Admin', 'admin@example.com');
    }

    protected function tearDown(): void
    {
        (new AdminAuthService(new SessionRepository))->logout();
        parent::tearDown();
    }

    public function test_store_author()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/users' => Http::response(null, 201),
        ]);

        $response = $this->postJson('/api/v1/admin/authors', [
            'name'  => 'Johny Depp',
            'email' => 'pirates@example.com',
        ]);
        $response
            ->assertStatus(201)
            ->assertJson([
                'result' => 'success',
                'data'   => null,
            ]);
    }
}
