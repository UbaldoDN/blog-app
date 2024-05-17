<?php

namespace Tests\Unit\Cache;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Cache;

class UpdateUserTest extends TestCase
{
    public function test_it_can_update_a_user_in_cache_with_put_request(): void
    {
        Cache::put('user_octavio_paz', [
            'name' => 'Octavio Paz',
            'email' => 'octavio.paz@example.com',
            'role' => 'author'
        ], 10);

        // La modificación solo fue el email
        Cache::put('user_octavio_paz', [
            'name' => 'Octavio Paz',
            'email' => 'octavio.paz.updated@example.com',
            'role' => 'author'
        ], 10);

        $cachedUser = Cache::get('user_octavio_paz');

        $this->assertEquals('Octavio Paz', $cachedUser['name']);
        $this->assertEquals('octavio.paz.updated@example.com', $cachedUser['email']);
        $this->assertEquals('author', $cachedUser['role']);
    }
}
