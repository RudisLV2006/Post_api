<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index'])
        ];
    }
    public function index(Post $post)
    {
        return $post->comments;
    }
    public function store(Request $request, Post $post)
    {
        $request->validate(
            [
                "text" => "required|max:255"
            ]
        );

        $request->user()->comment()->create([
            "post_id" => $post->id,
            "text" => $request->text,
        ]);

        return [
            "message" => "Comment has been created"
        ];
    }
    public function destroy(Post $post, Comment $comment)
    {

        Gate::authorize('delete', $comment);

        $comment->delete();
        return [
            "message" => "Succefully deleted"
        ];
    }
}
