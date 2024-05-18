<?php

namespace App\Services\Logs\Repositories;

use App\Services\Logs\Interfaces\LogRepositoryInterface;

final class FileLogRepository implements LogRepositoryInterface
{
    public function __construct(protected $logFilePath = null)
    {
        $this->logFilePath = $logFilePath ?? storage_path(env('LOG_PATH', 'logs/activity.log'));
    }

    public function save(?int $userId, ?string $name, ?string $email, string $method, string $url, int $statusCode, array $response = [], array $data = []): void
    {
        $logData = json_encode([
            'method'      => $method,
            'url'         => $url,
            'status_code' => $statusCode,
            'response'    => json_encode($response),
            'data'        => json_encode($data),
            'user_id'     => $userId,
            'user_name'   => $name,
            'user_email'  => $email,
            'ip_address'  => request()->ip(),
            'created_at'  => now()->toISOString(),
            'updated_at'  => now()->toISOString(),
        ]) . PHP_EOL;

        file_put_contents($this->logFilePath, $logData, FILE_APPEND);
    }
}
