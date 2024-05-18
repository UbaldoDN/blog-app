<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use App\Services\Auth\AdminAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UpdateAuthorTest extends TestCase
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

    public function test_update_author()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/users/2' => Http::response(null, 204),
        ]);

        $response = $this->putJson('/api/v1/admin/authors/2', [
            'name'  => 'Johny Depp',
            'email' => 'pirates@example.com',
        ]);
        $response
            ->assertStatus(204);
    }
}
