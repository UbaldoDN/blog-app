<?php

namespace Tests\Unit\Cache;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Cache;

class ListUserTest extends TestCase
{
    public function test_it_can_list_multiple_users_from_cache(): void
    {
        $users = [
            'user1' => [
                'name' => 'Octavio Paz',
                'email' => 'octavio.paz@example.com',
                'role' => 'author'
            ],
            'user2' => [
                'name' => 'Octavio Paz Jr',
                'email' => 'octavio.paz.jr@example.com',
                'role' => 'author'
            ],
            'user3' => [
                'name' => 'Octavio Paz Nieto',
                'email' => 'octavio.paz.nieto@example.com',
                'role' => 'author'
            ]
        ];

        Cache::put('users', $users, 10);

        $cachedUsers = Cache::get('users');

        $this->assertCount(3, $cachedUsers);
        // Octavio Paz
        $this->assertEquals('Octavio Paz', $cachedUsers['user1']['name']);
        $this->assertEquals('octavio.paz@example.com', $cachedUsers['user1']['email']);
        $this->assertEquals('author', $cachedUsers['user1']['role']);

        // Octavio Paz Jr
        $this->assertEquals('Octavio Paz Jr', $cachedUsers['user2']['name']);
        $this->assertEquals('octavio.paz.jr@example.com', $cachedUsers['user2']['email']);
        $this->assertEquals('author', $cachedUsers['user2']['role']);

        // Octavio Paz Nieto
        $this->assertEquals('Octavio Paz Nieto', $cachedUsers['user3']['name']);
        $this->assertEquals('octavio.paz.nieto@example.com', $cachedUsers['user3']['email']);
        $this->assertEquals('author', $cachedUsers['user3']['role']);
    }
}
