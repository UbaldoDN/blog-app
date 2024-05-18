<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use App\Services\Auth\AdminAuthService;
use App\Services\Auth\Repositories\SessionRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ListAuthorsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        (new AdminAuthService(new SessionRepository))->login(1, 'Admin', 'admin@example.com');
    }

    protected function tearDown(): void
    {
        (new AdminAuthService(new SessionRepository))->logout();
        parent::tearDown();
    }

    public function test_list_all_authors()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/users' => Http::response([
                ['id' => 1, 'name' => 'Leanne Graham', 'email' => 'Sincere@april.biz'],
                ['id' => 2, 'name' => 'Ervin Howell', 'email' => 'Shanna@melissa.tv'],
                ['id' => 3, 'name' => 'Clementine Bauch', 'email' => 'Nathan@yesenia.net'],
            ], 200),
        ]);

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
