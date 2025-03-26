<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

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
        return $post->comments()->get();
    }
    public function store(Request $request, Post $post)
    {
        $request->validate(
            [
                "text" => "required"
            ]
        );

        $comment = new Comment();
        $comment->text = $request->text;

        $comment->post_id = $post->id;
        $comment->user_id = $request->user()->id;

        $comment->save();

        return [
            "message" => "Comment has been created"
        ];
    }
}
