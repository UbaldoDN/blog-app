<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthorAuthService;
use App\Services\Logs\LogService;
use Illuminate\Http\JsonResponse;

class AuthorAuthController extends Controller
{
    public function __construct(protected AuthorAuthService $authorAuthService, protected LogService $logService)
    {
        //
    }
    
    /**
     * @OA\Post(
     *     path="/api/v1/author/login",
     *     summary="Login an author",
     *     description="Login an author",
     *     @OA\Response(
     *         response=200,
     *         description="Login successfully",
     *     )
     * )
     */
    public function login(): JsonResponse
    {
        $this->authorAuthService->login(2, 'Author', 'author@example.com');

        return $this->responseOk([
                'id'    => $this->authorAuthService->getUserId(),
                'name'  => $this->authorAuthService->getName(),
                'email' => $this->authorAuthService->getEmail(),
                'role'  => $this->authorAuthService->getRole(),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/author/logout",
     *     summary="Logout an author",
     *     description="Logout an author",
     *     @OA\Response(
     *         response=204,
     *         description="Logout successfully"
     *     )
     * )
     */
    public function logout(): JsonResponse
    {
        $this->authorAuthService->logout();

        $this->logService->log(
            $this->authorAuthService->getUserId(),
            $this->authorAuthService->getName(),
            $this->authorAuthService->getEmail(),
            'POST',
            '/author/logout',
            204
        );
        
        return $this->responseNoContent();
    }
}
