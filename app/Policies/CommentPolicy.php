<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class CommentPolicy
{
    public function delete(User $user, Comment $comment): Response
    {
        if ($comment->user_id === $user->id) {
            return Response::allow();
        }
        if ($comment->post->user_id === $user->id) {
            return Response::allow();
        }
        return Response::deny("You do not own this comment or not author");
    }
}
