<?php

namespace Tests\Feature\Http\Controllers\AuthorController;

use App\Services\Auth\AuthorAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class StorePostTest extends TestCase
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

    public function test_store_author()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/posts' => Http::response(null, 201),
        ]);

        $response = $this->postJson('/api/v1/authors/posts', [
            'title' => 'Title Test Posts 1',
            'body'  => 'Body Test Posts 1',
        ]);
        
        $response
            ->assertStatus(201)
            ->assertJson([
                'result' => 'success',
                'data'   => null,
            ]);
    }
}
