<?php

namespace Tests\Feature\Http\Controllers\PostController;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetPostTest extends TestCase
{
    public function test_get_one_post()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/posts/1' => Http::response(
                ['userId' => 1, 'id' => 1, 'title' => 'Tittle Id 1', 'body' => 'Body Id 1'],
                200
            ),
        ]);

        Http::fake([
            'jsonplaceholder.typicode.com/users/1' => Http::response(
                ['id' => 1, 'name' => 'Ervin Howell', 'email' => 'Shanna@melissa.tv'],
                200
            ),
        ]);

        $response = $this->getJson('/api/v1/posts/1');
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
                'data'   => [
                    'userId' => 1,
                    'id'     => 1,
                    'title'  => 'Tittle Id 1',
                    'body'   => 'Body Id 1',
                    'author' => [
                        'id'    => 1,
                        'name'  => 'Ervin Howell',
                        'email' => 'Shanna@melissa.tv',
                    ],
                ],
            ]);
    }
}
