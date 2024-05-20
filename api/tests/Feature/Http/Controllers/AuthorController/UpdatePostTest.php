<?php

namespace Tests\Feature\Http\Controllers\AuthorController;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_post()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/posts/2' => Http::response(null, 204),
        ]);

        $user = User::factory()->create([
            'id' => 2,
            'email' => 'author@example.com',
            'role' => 'author'
        ]);

        Sanctum::actingAs($user);

        $response = $this->putJson('/api/v1/authors/posts/2', [
            'title' => 'Update Title Test Post 2',
            'body'  => 'Update Body Test Post 2',
        ]);
        
        $response
            ->assertStatus(204);
    }
}
