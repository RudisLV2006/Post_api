<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostStatus extends Model
{
    const STATUS_PUBLIC = 'public';
    const STATUS_PRIVATE = 'private';

    // Define the inverse relationship to the posts
    public function posts()
    {
        return $this->hasMany(Post::class, 'post_status_id');
    }
}
