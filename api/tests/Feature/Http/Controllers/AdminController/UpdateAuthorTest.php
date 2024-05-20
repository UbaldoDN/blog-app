<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateAuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_author()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/users/2' => Http::response(null, 204),
        ]);

        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);

        Sanctum::actingAs($admin);
        User::factory()->create([
            'id' => 2,
            'email' => 'author@example.com',
            'role' => 'author'
        ]);

        $response = $this->putJson('/api/v1/admin/authors/2', [
            'name'  => 'Johny Depp',
            'email' => 'pirates@example.com',
        ]);
        
        $response
            ->assertStatus(204);
    }
}
