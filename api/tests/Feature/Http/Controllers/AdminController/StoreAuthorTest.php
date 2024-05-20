<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreAuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_author()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/users' => Http::response(null, 201),
        ]);

        $user = User::factory()->create([
            'id' => 1,
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/admin/authors', [
            'name'  => 'Johny Depp',
            'email' => 'pirates@example.com',
        ]);
        $response
            ->assertStatus(201)
            ->assertJson([
                'result' => 'success',
                'data'   => null,
            ]);
    }
}
