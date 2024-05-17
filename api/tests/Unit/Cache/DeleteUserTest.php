<?php

namespace Tests\Unit\Cache;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Cache;

class DeleteUserTest extends TestCase
{
    public function test_it_can_delete_a_user_from_cache_with_delete_request(): void
    {
        Cache::put('user_octavio_paz', [
            'name' => 'Octavio Paz',
            'email' => 'octavio.paz@example.com',
            'role' => 'author'
        ], 10);

        $this->assertTrue(Cache::has('user_octavio_paz'));

        Cache::forget('user_octavio_paz');

        $this->assertFalse(Cache::has('user_octavio_paz'));
    }
}
