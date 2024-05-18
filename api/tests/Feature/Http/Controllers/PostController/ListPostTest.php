<?php

namespace Tests\Feature\Http\Controllers\PostController;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ListPostTest extends TestCase
{
    public function test_list_all_posts()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/posts' => Http::response([
                ['userId' => 1, 'id' => 1, 'title' => 'Tittle Id 1', 'body' => 'Body Id 1'],
                ['userId' => 2, 'id' => 2, 'title' => 'Tittle Id 2', 'body' => 'Body Id 2'],
                ['userId' => 3, 'id' => 3, 'title' => 'Tittle Id 3', 'body' => 'Body Id 3'],
            ], 200),
        ]);

        $response = $this->getJson('/api/v1/posts');
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
                'data'   => [
                    ['userId' => 1, 'id' => 1, 'title' => 'Tittle Id 1', 'body' => 'Body Id 1'],
                    ['userId' => 2, 'id' => 2, 'title' => 'Tittle Id 2', 'body' => 'Body Id 2'],
                    ['userId' => 3, 'id' => 3, 'title' => 'Tittle Id 3', 'body' => 'Body Id 3'],
                ],
            ]);
    }
}
