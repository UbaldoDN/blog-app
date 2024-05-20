<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AdminAuthService;
use Illuminate\Http\Request;
use App\Services\Logs\LogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected LogService $logService)
    {
        //
    }
    
    /**
     * @OA\Post(
     *     path="/api/v1/admin/login",
     *     summary="Login an admin",
     *     description="Login an admin",
     *     @OA\Response(
     *         response=200,
     *         description="Login successfully",
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $this->logService->log( $user->id, $user->name, $user->email, $request->method(), $request->url(), 200);

            return $this->responseOk(['token' => $user->createToken('authToken')->plainTextToken, 'user' => $user]);
        }

        return $this->responseError(['error' => 'Unauthorized'], 401);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/admin/logout",
     *     summary="Logout an admin",
     *     description="Logout an admin",
     *     @OA\Response(
     *         response=204,
     *         description="Logout successfully"
     *     )
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $this->logService->log( $request->user()->id, $request->user()->name, $request->user()->email, $request->method(), $request->url(), 204 );
        $request->user()->currentAccessToken()->delete();

        return $this->responseOk();
    }
}
