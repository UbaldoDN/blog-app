<?php

namespace App\Http\Controllers;

use App\Http\Requests\Author\StorePostRequest;
use App\Http\Requests\Author\UpdatePostRequest;
use App\Services\Auth\AuthorAuthService;
use App\Services\HttpClients\JsonPlaceHolder\AuthorHttpClientsService;
use App\Services\Logs\LogService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    use ApiResponse;

    public function __construct(protected AuthorAuthService $authorAuthService, protected AuthorHttpClientsService $authorService, protected LogService $logService)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/authors/posts",
     *     summary="Get an author all post",
     *     description="Get an author all post",
     *     @OA\Response(
     *         response=200,
     *         description="Get an author all post",
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $posts = $this->authorService->getPosts($this->authorAuthService->getUserId());
        $this->logService->log(
            $this->authorAuthService->getUserId(),
            $this->authorAuthService->getName(),
            $this->authorAuthService->getEmail(),
            'GET',
            '/authors/posts',
            200,
            $posts
        );

        return $this->responseOk($posts);
    }
    
    /**
     * @OA\Get(
     *     path="/api/v1/admin/authors/posts/{$id}",
     *     summary="Get an author with one post",
     *     description="Get an author with one post",
     *     @OA\Response(
     *         response=200,
     *         description="Get an author with one post",
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $post = $this->authorService->getPost($id, $this->authorAuthService->getUserId());
        $this->logService->log(
            $this->authorAuthService->getUserId(),
            $this->authorAuthService->getName(),
            $this->authorAuthService->getEmail(),
            'GET',
            "/authors/posts/{$id}",
            200,
            $post
        );

        return $this->responseOk($post);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/admin/authors/posts",
     *     summary="Store an post",
     *     description="Store an post",
     *     @OA\Response(
     *         response=201,
     *         description="Store an post",
     *     )
     * )
     */

    public function store(StorePostRequest $request): JsonResponse
    {
        $this->authorService->storePost($this->authorAuthService->getUserId(), $request->all()['title'], $request->all()['body']);
        $this->logService->log(
            $this->authorAuthService->getUserId(),
            $this->authorAuthService->getName(),
            $this->authorAuthService->getEmail(),
            'POST',
            "/authors/posts",
            201
        );

        return $this->responseCreated();
    }

    /**
     * @OA\Put(
     *     path="/api/v1/admin/authors/posts/{$id}",
     *     summary="Update one post",
     *     description="Update one post",
     *     @OA\Response(
     *         response=204,
     *         description="Update one post",
     *     )
     * )
     */
    public function update(UpdatePostRequest $request, int $id): JsonResponse
    {
        $this->authorService->updatePost($id, $this->authorAuthService->getUserId(), $request->all()['title'], $request->all()['body']);
        $this->logService->log(
            $this->authorAuthService->getUserId(),
            $this->authorAuthService->getName(),
            $this->authorAuthService->getEmail(),
            'PUT',
            "/authors/posts/{$id}",
            204
        );

        return $this->responseNoContent();
    }
}
