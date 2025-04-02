<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class CommentPolicy
{
    public function delete(User $user, Comment $comment): Response
    {

        return $user->id === $comment->user_id ? Response::allow() : Response::deny("You do not own this comment");
    }
}
