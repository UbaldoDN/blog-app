<?php

namespace App\Services\Auth;

use App\Services\Auth\Repositories\AuthFacadeRepository;

final class AdminAuthService
{
    public function __construct(protected AuthFacadeRepository $facadeRepository)
    {
        //
    }

    public function login(int $adminId, string $name, string $email)
    {
        $this->facadeRepository->login($adminId, $name, $email, 'admin');
    }

    public function logout()
    {
        $this->facadeRepository->logout();
    }

    public function isLoggedIn(): bool
    {
        return $this->facadeRepository->isLoggedIn() !== null;
    }

    public function getUserId(): int | null
    {
        return $this->facadeRepository->getUserId();
    }
    
    public function getName(): string | null
    {
        return $this->facadeRepository->getName();
    }

    public function getEmail(): string | null
    {
        return $this->facadeRepository->getEmail();
    }

    public function getRole(): string | null
    {
        return $this->facadeRepository->getRole();
    }
}
