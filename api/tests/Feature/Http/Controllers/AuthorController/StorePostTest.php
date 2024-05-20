<?php

namespace Tests\Feature\Http\Controllers\AuthorController;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StorePostTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_author()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/posts' => Http::response(null, 201),
        ]);

        $user = User::factory()->create([
            'email' => 'author@example.com',
            'role' => 'author'
        ]);

        Sanctum::actingAs($user);

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
