<?php

namespace Tests\Unit\Cache;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Cache;

class GetUserTest extends TestCase
{
    public function test_it_can_retrieve_a_user_from_cache_with_get_request(): void
    {
        Cache::put('user_carlos_fuentes', [
            'name' => 'Carlos Fuentes',
            'email' => 'carlos.fuentes@example.com',
            'role' => 'author'
        ], 10);

        $cachedUser = Cache::get('user_carlos_fuentes');

        $this->assertEquals('Carlos Fuentes', $cachedUser['name']);
        $this->assertEquals('carlos.fuentes@example.com', $cachedUser['email']);
        $this->assertEquals('author', $cachedUser['role']);
    }
}
