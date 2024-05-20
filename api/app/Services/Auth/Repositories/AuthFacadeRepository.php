<?php

namespace App\Services\Auth\Repositories;

use App\Services\Auth\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Auth;

final class AuthFacadeRepository implements AuthInterface
{
    public function login(int $userId, string $name, string $email, string $role)
    {
        //
    }

    public function logout()
    {
        //
    }

    public function isLoggedIn()
    {
        return Auth::check();
    }

    public function getUserId()
    {
        return Auth::user()->id;
    }

    public function getName()
    {
        return Auth::user()->name;
    }

    public function getEmail()
    {
        return Auth::user()->email;
    }

    public function getRole()
    {
        return Auth::user()->role;
    }
}
