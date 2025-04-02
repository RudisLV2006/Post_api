<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('posts', PostController::class);
Route::post('posts/{post}/comment', [CommentController::class, "store"]);
Route::get('posts/{post}/comment', [CommentController::class, "index"])->name("comment.index");
Route::delete('posts/{post}/comment/{comment}', [CommentController::class, "destroy"]);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
