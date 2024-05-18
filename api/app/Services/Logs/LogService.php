<?php

namespace App\Services\Logs;

use App\Services\Logs\Repositories\FileLogRepository;

final class LogService
{
    public function __construct(protected FileLogRepository $fileLogRepository)
    {
        //
    }

    public function log(?int $userId, ?string $name, ?string $email, string $method, string $url, int $statusCode, array $response = [], array $data = []): void
    {
        if (env('APP_ENV') !== 'testing') {
            $this->fileLogRepository->save($userId, $name, $email, $method, $url, $statusCode, $response, $data);
        }
    }
}
