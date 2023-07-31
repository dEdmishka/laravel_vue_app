<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request)
    {
        return $request->user();
    });

//    Route::get('/posts', [PostController::class, 'index']);
//    Route::post('/posts', [PostController::class, 'store']);
//    Route::get('/users', [UserController::class, 'show']);
    Route::get('/auth-user', [AuthUserController::class, 'show']);

    Route::apiResources([
        '/posts' => PostController::class,
        '/users' => UserController::class,
        '/users/{user}/posts' => UserPostController::class,
    ]);
});
