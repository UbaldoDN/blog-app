<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use App\Services\Auth\AdminAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetAuthorPostsTest extends TestCase
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

    public function test_get_one_author_with_posts()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/users/2/posts' => Http::response(
                [
                    ['userId' => 2, 'id' => 11, 'title' => 'Tittle Id 11', 'body' => 'Body Id 11'],
                    ['userId' => 2, 'id' => 12, 'title' => 'Tittle Id 12', 'body' => 'Body Id 12'],
                    ['userId' => 2, 'id' => 13, 'title' => 'Tittle Id 13', 'body' => 'Body Id 13'],
                ],
                200
            ),
        ]);

        Http::fake([
            'jsonplaceholder.typicode.com/users/2' => Http::response(
                ['id' => 2, 'name' => 'Ervin Howell', 'email' => 'Shanna@melissa.tv'],
                200
            ),
        ]);

        $response = $this->getJson('/api/v1/admin/authors/2/posts');
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
                'data'   => [
                    'author' => [
                        'id'    => 2,
                        'name'  => 'Ervin Howell',
                        'email' => 'Shanna@melissa.tv',
                        'posts' => [
                            ['userId' => 2, 'id' => 11, 'title' => 'Tittle Id 11', 'body' => 'Body Id 11'],
                            ['userId' => 2, 'id' => 12, 'title' => 'Tittle Id 12', 'body' => 'Body Id 12'],
                            ['userId' => 2, 'id' => 13, 'title' => 'Tittle Id 13', 'body' => 'Body Id 13'],
                        ],
                    ],
                ],
            ]);
    }
}
