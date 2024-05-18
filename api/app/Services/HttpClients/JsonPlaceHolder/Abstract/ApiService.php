<?php

namespace App\Services\HttpClients\JsonPlaceHolder\Abstract;

use Illuminate\Support\Facades\Http;

abstract class ApiService
{
    public function __construct(protected $baseUri)
    {
        //
    }

    protected function getRequest(string $endpoint): array | null
    {
        $response = Http::get("{$this->baseUri}{$endpoint}");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    protected function postRequest(string $endpoint, array $data): bool
    {
        $response = Http::post("{$this->baseUri}{$endpoint}", $data);

        if ($response->successful()) {
            return true;
        }

        return false;
    }

    protected function putRequest(string $endpoint, array $data): bool
    {
        $response = Http::put("{$this->baseUri}{$endpoint}", $data);

        if ($response->successful()) {
            return true;
        }

        return false;
    }

    protected function patchRequest(string $endpoint, array $data): array | null
    {
        $response = Http::patch("{$this->baseUri}{$endpoint}", $data);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

}
