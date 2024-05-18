<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use App\Services\Auth\AdminAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetAuthorTest extends TestCase
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

    public function test_get_one_author()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/users/2' => Http::response(
                ['id' => 2, 'name' => 'Ervin Howell', 'email' => 'Shanna@melissa.tv'],
                200
            ),
        ]);

        $response = $this->getJson('/api/v1/admin/authors/2');
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
                'data'   => ['id' => 2, 'name' => 'Ervin Howell', 'email' => 'Shanna@melissa.tv'],
            ]);
    }
}
