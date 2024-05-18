<?php

namespace App\Http\Middleware;

use App\Services\Auth\AdminAuthService;
use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    use ApiResponse;

    public function __construct(protected AdminAuthService $adminAuthService)
    {
        //
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->adminAuthService->isLoggedIn() && $this->adminAuthService->getRole() === 'admin') {
            return $next($request);
        }
        
        return $this->responseError(['error' => 'Unauthorized'], 401);
    }
}
