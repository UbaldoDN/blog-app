<?php

namespace Tests\Feature\Http\Controllers\AuthorController;

use App\Services\Auth\AuthorAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetPostTest extends TestCase
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

    public function test_get_one_post()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/posts/2' => Http::response(
                ['userId' => 2, 'id' => 2, 'title' => 'Tittle Id 2', 'body' => 'Body Id 2'],
                200
            ),
        ]);

        Http::fake([
            'jsonplaceholder.typicode.com/users/2' => Http::response(
                ['id' => 2, 'name' => 'Ervin Howell', 'email' => 'Shanna@melissa.tv'],
                200
            ),
        ]);

        $response = $this->getJson('/api/v1/authors/posts/2');
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
                'data'   => [
                    'author' => [
                        'id'    => 2,
                        'name'  => 'Ervin Howell',
                        'email' => 'Shanna@melissa.tv',
                        'posts' => ['userId' => 2, 'id' => 2, 'title' => 'Tittle Id 2', 'body' => 'Body Id 2'],
                    ],
                ],
            ]);
    }
}
