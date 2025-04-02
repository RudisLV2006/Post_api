<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Client\Response;

class PostPolicy
{
    public function modify(User $user, Post $post): Response  //7
    {
        return $user->id === $post->user_id ? Response::allow() : Response::deny("You do not own this post");
    }
}
