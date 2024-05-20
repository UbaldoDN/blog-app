<?php

namespace Tests\Feature\Http\Controllers\AuthorController;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_all_posts()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/users/2/posts' => Http::response([
                ['userId' => 2, 'id' => 11, 'title' => 'Tittle Id 11', 'body' => 'Body Id 11'],
                ['userId' => 2, 'id' => 12, 'title' => 'Tittle Id 12', 'body' => 'Body Id 12'],
                ['userId' => 2, 'id' => 13, 'title' => 'Tittle Id 13', 'body' => 'Body Id 13'],
            ], 200),
        ]);

        $user = User::factory()->create([
            'id' => 2,
            'email' => 'author@example.com',
            'role' => 'author'
        ]);

        Sanctum::actingAs($user);
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
