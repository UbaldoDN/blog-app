<?php

namespace Tests\Feature\Http\Controllers\AuthorController;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetPostTest extends TestCase
{
    use RefreshDatabase;

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

        $user = User::factory()->create([
            'id' => 2,
            'email' => 'author@example.com',
            'role' => 'author'
        ]);

        Sanctum::actingAs($user);

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
