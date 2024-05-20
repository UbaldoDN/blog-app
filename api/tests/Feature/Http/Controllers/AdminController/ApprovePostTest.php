<?php

namespace Tests\Feature\Http\Controllers\AdminController;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApprovePostTest extends TestCase
{
    use RefreshDatabase;

    public function test_approved_post()
    {
        Http::fake([
            'jsonplaceholder.typicode.com/posts/1' => Http::response([
                'approved'     => true,
                'published_at' => Carbon::now(),
            ], 204),
        ]);
        $user = User::factory()->create([
            'id' => 1,
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);

        Sanctum::actingAs($user);
        $response = $this->patchJson('/api/v1/admin/posts/1/approve');
        $response->assertStatus(204);
    }
}
