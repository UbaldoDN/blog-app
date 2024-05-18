<?php

namespace App\Http\Middleware;

use App\Services\Auth\AuthorAuthService;
use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthorRole
{
    use ApiResponse;

    public function __construct(protected AuthorAuthService $authorAuthService)
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
        if (($this->authorAuthService->isLoggedIn() && $this->authorAuthService->getRole() === 'author')) {
            return $next($request);
        }
        
        return $this->responseError(['error' => 'Unauthorized', 'env' => $this->authorAuthService->getRole()], 401);
    }
}
