<?php

namespace Tests\Unit\Cache;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Cache;

class StoreUserTest extends TestCase
{
    public function test_it_can_store_a_user_in_cache_with_post_request(): void
    {
        Cache::add('user_octavio_paz', [
            'name' => 'Octavio Paz',
            'email' => 'octavio.paz@example.com',
            'role' => 'author'
        ], 10);

        $this->assertTrue(Cache::has('user_octavio_paz'));
    }
}
