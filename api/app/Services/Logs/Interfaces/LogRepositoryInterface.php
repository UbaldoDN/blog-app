<?php

namespace App\Services\Logs\Interfaces;

interface LogRepositoryInterface
{
    public function save(int $userId, string $name, string $email, string $method, string $url, int $statusCode, array $response, array $data): void;
}
