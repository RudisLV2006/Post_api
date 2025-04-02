<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostStatus;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // \Log::debug(Post::has('comments')->get());

        $user = Auth::user(); // Get the authenticated user

        // Query posts with either 'public' status for all or 'private' status only for the current user
        $posts = Post::with('comments')  // Eager load the comments
            ->where(function ($query) use ($user) {
                // Show public posts to all users
                $query->whereHas('status', function ($statusQuery) {
                    $statusQuery->where('name', PostStatus::STATUS_PUBLIC);  // Filter by public status
                });

                // Show private posts only for the authenticated user
                $query->orWhere(function ($privateQuery) use ($user) {
                    $privateQuery->whereHas('status', function ($statusQuery) {
                        $statusQuery->where('name', PostStatus::STATUS_PRIVATE);  // Filter by private status
                    });
                    $privateQuery->where('user_id', $user->id);  // Check if the user is the owner of the post
                });
            })
            ->get();

        return $posts;  //3
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',  //4
            'post_status' => 'required|in:' . PostStatus::STATUS_PUBLIC . ',' . PostStatus::STATUS_PRIVATE,
        ]);

        $statusId = PostStatus::where('name', $fields['post_status'])->first()->id;

        $post = Post::create([
            'title' => $fields['title'],
            'user_id' => auth()->id(),
            'body' => $fields['body'],
            'post_status_id' => $statusId,  // Store the status ID
        ]);

        return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'post_status_id' => 'required|in:' . PostStatus::STATUS_PUBLIC . ',' . PostStatus::STATUS_PRIVATE,
        ]);

        $post->update($fields);

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);
        $post->delete();
        return ['message' => "The post ($post->id) has been deleted"];
    }
}
