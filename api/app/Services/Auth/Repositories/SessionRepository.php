<?php

namespace App\Services\Auth\Repositories;

use App\Services\Auth\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Session;

final class SessionRepository implements AuthInterface
{
    public function login(int $userId, string $name, string $email, string $role)
    {
        Session::put('user_id', $userId);
        Session::put('name', $name);
        Session::put('email', $email);
        Session::put('role', $role);
    }

    public function logout()
    {
        Session::forget(['user_id', 'name', 'email', 'role']);
        Session::flush();
    }

    public function isLoggedIn()
    {
        return Session::has('user_id');
    }

    public function getUserId()
    {
        return Session::get('user_id');
    }

    public function getName()
    {
        return Session::get('name');
    }

    public function getEmail()
    {
        return Session::get('email');
    }

    public function getRole()
    {
        return Session::get('role');
    }
}
