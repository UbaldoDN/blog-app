<?php

namespace Tests\Feature\Http\Controllers\AuthorController;

use App\Services\Auth\AuthorAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (new AuthorAuthService(new SessionRepository))->login(2, 'Author', 'author@example.com');
    }

    protected function tearDown(): void
    {
        (new AuthorAuthService(new SessionRepository))->logout();
        parent::tearDown();
    }

    public function test_update_post()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/posts/2' => Http::response(null, 204),
        ]);

        $response = $this->putJson('/api/v1/authors/posts/2', [
            'title' => 'Update Title Test Post 2',
            'body'  => 'Update Body Test Post 2',
        ]);
        
        $response
            ->assertStatus(204);
    }
}
