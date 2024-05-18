<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use App\Services\Auth\AdminAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApprovePostTest extends TestCase
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

    public function test_approved_post()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/posts/1' => Http::response([
                'approved'     => true,
                'published_at' => Carbon::now(),
            ], 204),
        ]);

        $response = $this->patchJson('/api/v1/admin/posts/1/approve');
        $response->assertStatus(204);
    }
}
