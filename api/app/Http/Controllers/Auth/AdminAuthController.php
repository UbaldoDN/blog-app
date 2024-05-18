<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AdminAuthService;
use App\Services\Logs\LogService;
use Illuminate\Http\JsonResponse;

class AdminAuthController extends Controller
{
    public function __construct(protected AdminAuthService $adminAuthService, protected LogService $logService)
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
    public function login(): JsonResponse
    {
        $this->adminAuthService->login(1, 'Admin', 'admin@example.com');
        $data = [
            'id'    => $this->adminAuthService->getUserId(),
            'name'  => $this->adminAuthService->getName(),
            'email' => $this->adminAuthService->getEmail(),
            'role'  => $this->adminAuthService->getRole(),
        ];
        
        $this->logService->log(
            $data['id'],
            $data['name'],
            $data['email'],
            'POST',
            '/admin/login',
            200,
            $data
        );

        return $this->responseOk($data);
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
    public function logout(): JsonResponse
    {
        $this->logService->log(
            $this->adminAuthService->getUserId(),
            $this->adminAuthService->getName(),
            $this->adminAuthService->getEmail(),
            'POST',
            '/admin/logout',
            204
        );
        
        $this->adminAuthService->logout();

        return $this->responseNoContent();
    }
}
