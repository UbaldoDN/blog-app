<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_one_author()
    {
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

        $response = $this->getJson('/api/v1/admin/authors/2');
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
                'data'   => ['id' => 2, 'name' => 'Ervin Howell', 'email' => 'Shanna@melissa.tv'],
            ]);
    }
}
