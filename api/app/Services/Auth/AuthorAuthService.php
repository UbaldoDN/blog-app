<?php

namespace App\Services\Auth;

use App\Services\Auth\Repositories\SessionRepository;

final class AuthorAuthService
{
    public function __construct(protected SessionRepository $sessionRepository)
    {
        //
    }

    public function login(int $authorId, string $name, string $email)
    {
        $this->sessionRepository->login($authorId, $name, $email, 'author');
    }

    public function logout()
    {
        $this->sessionRepository->logout();
    }

    public function isLoggedIn(): bool
    {
        return $this->sessionRepository->isLoggedIn() !== null;
    }

    public function getUserId(): int | null
    {
        return $this->sessionRepository->getUserId();
    }
    
    public function getName(): string | null
    {
        return $this->sessionRepository->getName();
    }

    public function getEmail(): string | null
    {
        return $this->sessionRepository->getEmail();
    }

    public function getRole(): string | null
    {
        return $this->sessionRepository->getRole();
    }
}
