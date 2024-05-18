<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function responseOk($data = []): JsonResponse
    {
        return response()->json([
            'result' => 'success',
            'data'   => $data,
        ], 200);
    }

    public function responseCreated(): JsonResponse
    {
        return response()->json([
            'result' => 'success',
            'data'   => null,
        ], 201);
    }

    public function responseNoContent(): JsonResponse
    {
        return response()->json([], 204);
    }

    public function responseError($data = [], $code = 400): JsonResponse
    {
        return response()->json([
            'result' => 'error',
            'data'   => $data,
        ], $code);
    }
}
