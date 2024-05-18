<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthorAuthController;

use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckAuthorRole;

Route::prefix('v1')->group(function () {
    Route::prefix('posts')->group(function () {
        Route::get('/', [PostsController::class, 'index']);
        Route::get('/{id}', [PostsController::class, 'show']);
    });

    Route::prefix('authors')->group(function () {
        Route::post('login', [AuthorAuthController::class, 'login']);
        Route::post('logout', [AuthorAuthController::class, 'logout']);

        // PHPUnit
        Route::middleware([CheckAuthorRole::class])->group(function () {
            Route::get('/posts', [AuthorController::class, 'index']);
            Route::get('/posts/{id}', [AuthorController::class, 'show']);
            Route::post('/posts', [AuthorController::class, 'store']);
            Route::put('/posts/{id}', [AuthorController::class, 'update']);
        });

        Route::middleware([CheckAuthorRole::class])->group(function () {
            Route::get('/posts', [AuthorController::class, 'index']);
            Route::get('/posts/{id}', [AuthorController::class, 'show']);
            Route::post('/posts', [AuthorController::class, 'store']);
            Route::put('/posts/{id}', [AuthorController::class, 'update']);
        });
    });

    Route::prefix('admin')->group(function () {
        Route::post('login', [AdminAuthController::class, 'login']);
        Route::post('logout', [AdminAuthController::class, 'logout']);

        Route::middleware([CheckAdminRole::class])->group(function () {
            Route::get('/authors', [AdminController::class, 'index']);
            Route::get('/authors/{id}', [AdminController::class, 'showAuthor']);
            Route::get('/authors/{id}/posts', [AdminController::class, 'showAuthorPosts']);
            Route::post('/authors', [AdminController::class, 'storeAuthor']);
            Route::put('/authors/{id}', [AdminController::class, 'updateAuthor']);
            Route::patch('/posts/{id}/approve', [AdminController::class, 'approvePost']);
        });
    });
});
