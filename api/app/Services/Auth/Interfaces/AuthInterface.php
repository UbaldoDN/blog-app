<?php

namespace App\Services\Auth\Interfaces;

interface AuthInterface
{
    public function login(int $userId, string $name, string $email, string $role);
    public function logout();
    public function isLoggedIn();
    public function getUserId();
    public function getName();
    public function getEmail();
    public function getRole();
}
