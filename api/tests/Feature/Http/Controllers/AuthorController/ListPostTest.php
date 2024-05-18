<?php

namespace Tests\Feature\Http\Controllers\AuthorController;

use App\Services\Auth\AuthorAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ListPostTest extends TestCase
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

    public function test_list_all_posts()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/users/2/posts' => Http::response([
                ['userId' => 2, 'id' => 11, 'title' => 'Tittle Id 11', 'body' => 'Body Id 11'],
                ['userId' => 2, 'id' => 12, 'title' => 'Tittle Id 12', 'body' => 'Body Id 12'],
                ['userId' => 2, 'id' => 13, 'title' => 'Tittle Id 13', 'body' => 'Body Id 13'],
            ], 200),
        ]);

        $response = $this->getJson('/api/v1/authors/posts');
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
                'data'   => [
                    ['userId' => 2, 'id' => 11, 'title' => 'Tittle Id 11', 'body' => 'Body Id 11'],
                    ['userId' => 2, 'id' => 12, 'title' => 'Tittle Id 12', 'body' => 'Body Id 12'],
                    ['userId' => 2, 'id' => 13, 'title' => 'Tittle Id 13', 'body' => 'Body Id 13'],
                ],
            ]);
    }
}
