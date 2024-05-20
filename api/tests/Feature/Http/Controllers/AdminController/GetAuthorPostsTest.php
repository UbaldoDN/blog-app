<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAuthorPostsTest extends TestCase
{
    use RefreshDatabase;

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

        $user = User::factory()->create([
            'id' => 1,
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);

        User::factory()->create([
            'id' => 2,
            'email' => 'author@example.com',
            'role' => 'author'
        ]);

        Sanctum::actingAs($user);

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
