<?php

namespace App\Http\Controllers;

use App\Services\HttpClients\JsonPlaceHolder\PostsHttpClientsService;
use App\Services\Logs\LogService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class PostsController extends Controller
{
    use ApiResponse;

    public function __construct(protected PostsHttpClientsService $postsService, protected LogService $logService)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/v1/posts",
     *     summary="Get all post",
     *     description="Get all post",
     *     @OA\Response(
     *         response=200,
     *         description="Get all post",
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $posts = $this->postsService->getAll();
        $this->logService->log(
            null,
            'Guest',
            null,
            'GET',
            '/posts',
            200,
            $posts
        );

        return $this->responseOk($posts);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/posts/{id}",
     *     summary="Get an post with one author info",
     *     description="Get an post with one author info",
     *     @OA\Response(
     *         response=200,
     *         description="Get an post with one author info",
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $post = $this->postsService->getById($id);
        $this->logService->log(
            null,
            'Guest',
            null,
            'GET',
            "/posts/{$id}",
            200,
            $post
        );

        return $this->responseOk($post);
    }
}
