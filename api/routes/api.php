<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Middleware\CheckRole;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::prefix('posts')->group(function () {
        Route::get('/', [PostsController::class, 'index']);
        Route::get('/{id}', [PostsController::class, 'show']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware([CheckRole::class . ':author'])->prefix('authors')->group(function () {
            Route::get('/posts', [AuthorController::class, 'index']);
            Route::get('/posts/{id}', [AuthorController::class, 'show']);
            Route::post('/posts', [AuthorController::class, 'store']);
            Route::put('/posts/{id}', [AuthorController::class, 'update']);
        });

        Route::middleware([CheckRole::class . ':admin'])->prefix('admin')->group(function () {
            Route::get('/authors', [AdminController::class, 'index']);
            Route::get('/authors/{id}', [AdminController::class, 'showAuthor']);
            Route::get('/authors/{id}/posts', [AdminController::class, 'showAuthorPosts']);
            Route::post('/authors', [AdminController::class, 'storeAuthor']);
            Route::put('/authors/{id}', [AdminController::class, 'updateAuthor']);
            Route::patch('/posts/{id}/approve', [AdminController::class, 'approvePost']);
        });
    });
});
