<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreAuthorRequest;
use App\Http\Requests\Admin\UpdateAuthorRequest;
use App\Services\Auth\AdminAuthService;
use App\Services\HttpClients\JsonPlaceHolder\AdminHttpClientsService;
use App\Services\Logs\LogService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    use ApiResponse;

    public function __construct(protected AdminAuthService $adminAuthService, protected AdminHttpClientsService $adminService, protected LogService $logService)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/authors",
     *     summary="Get all authors",
     *     description="Get all authors",
     *     @OA\Response(
     *         response=200,
     *         description="Get all authors",
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $authors = $this->adminService->getAllAuthors();
        $this->logService->log(
            $this->adminAuthService->getUserId(),
            $this->adminAuthService->getName(),
            $this->adminAuthService->getEmail(),
            'GET',
            '/admin/authors',
            200,
            $authors
        );

        return $this->responseOk($authors);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/authors/{$authorId}",
     *     summary="Get one author",
     *     description="Get one author",
     *     @OA\Response(
     *         response=200,
     *         description="Get one author",
     *     )
     * )
     */
    public function showAuthor(int $authorId): JsonResponse
    {
        $author = $this->adminService->getAuthor($authorId);
        $this->logService->log(
            $this->adminAuthService->getUserId(),
            $this->adminAuthService->getName(),
            $this->adminAuthService->getEmail(),
            'GET',
            "/admin/authors/{$authorId}",
            200,
            $author
        );

        return $this->responseOk($author);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/authors/{$authorId}/post",
     *     summary="Get one authors with posts",
     *     description="Get one authors with posts",
     *     @OA\Response(
     *         response=200,
     *         description="Get one authors with posts",
     *     )
     * )
     */
    public function showAuthorPosts(int $authorId): JsonResponse
    {
        $authorPosts = $this->adminService->getAuthorPosts($authorId);
        $this->logService->log(
            $this->adminAuthService->getUserId(),
            $this->adminAuthService->getName(),
            $this->adminAuthService->getEmail(),
            'GET',
            "/admin/authors/{$authorId}/post",
            200,
            $authorPosts
        );

        return $this->responseOk($authorPosts);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/admin/authors",
     *     summary="Store one author",
     *     description="Store one author",
     *     @OA\Response(
     *         response=201,
     *         description="Store one author",
     *     )
     * )
     */
    public function storeAuthor(StoreAuthorRequest $request): JsonResponse
    {
        $this->adminService->storeAuthor($request->validated()['name'], $request->validated()['email']);
        $this->logService->log(
            $this->adminAuthService->getUserId(),
            $this->adminAuthService->getName(),
            $this->adminAuthService->getEmail(),
            'POST',
            "/admin/authors",
            201
        );

        return $this->responseCreated();
    }

    /**
     * @OA\Put(
     *     path="/api/v1/admin/authors/{$id}",
     *     summary="Update an author",
     *     description="Update an author",
     *     @OA\Response(
     *         response=200,
     *         description="Update an author",
     *     )
     * )
     */
    public function updateAuthor(int $id, UpdateAuthorRequest $request): JsonResponse
    {
        $this->adminService->updateAuthor($id, $request->validated()['name'], $request->validated()['email']);
        $this->logService->log(
            $this->adminAuthService->getUserId(),
            $this->adminAuthService->getName(),
            $this->adminAuthService->getEmail(),
            'PUT',
            "/admin/authors/{$id}",
            204
        );

        return $this->responseNoContent();
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/admin/posts/{$id}/approve",
     *     summary="Approve one post",
     *     description="Approve one post",
     *     @OA\Response(
     *         response=204,
     *         description="Approve one post",
     *     )
     * )
     */
    public function approvePost(int $id): JsonResponse
    {
        $this->adminService->approvePost($id);
        $this->logService->log(
            $this->adminAuthService->getUserId(),
            $this->adminAuthService->getName(),
            $this->adminAuthService->getEmail(),
            'PATCH',
            "/posts/{$id}/approve",
            204
        );
        
        return $this->responseNoContent();
    }
}
