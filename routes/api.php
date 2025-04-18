<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('users/{user}/assign-role', [RoleController::class, "addRole"])->name("user.addrole");

Route::apiResource('posts', PostController::class);
Route::patch('posts/{post}/status', [PostController::class, "changeStatus"])->name("post.status");
Route::post('posts/{post}/comment', [CommentController::class, "store"]);
Route::get('posts/{post}/comment', [CommentController::class, "index"])->name("comment.index");
Route::delete('posts/{post}/comment/{comment}', [CommentController::class, "destroy"])->name("comment.destroy");

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
