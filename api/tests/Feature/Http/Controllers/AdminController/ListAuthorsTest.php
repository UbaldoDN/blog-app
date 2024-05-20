<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListAuthorsTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_all_authors()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/users' => Http::response([
                ['id' => 1, 'name' => 'Leanne Graham', 'email' => 'Sincere@april.biz'],
                ['id' => 2, 'name' => 'Ervin Howell', 'email' => 'Shanna@melissa.tv'],
                ['id' => 3, 'name' => 'Clementine Bauch', 'email' => 'Nathan@yesenia.net'],
            ], 200),
        ]);

        $user = User::factory()->create([
            'id' => 1,
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/admin/authors');

        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'success',
                'data'   => [
                    ['id' => 1, 'name' => 'Leanne Graham', 'email' => 'Sincere@april.biz'],
                    ['id' => 2, 'name' => 'Ervin Howell', 'email' => 'Shanna@melissa.tv'],
                    ['id' => 3, 'name' => 'Clementine Bauch', 'email' => 'Nathan@yesenia.net'],
                ],
            ]);
    }
}
