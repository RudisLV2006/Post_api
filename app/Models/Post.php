<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', "user_id", "post_status_id"];

    public function user()
    {
        return $this->belongsTo(User::class); //6
    }
    public function comments()
    {
        return $this->hasMany(Comment::class); //6
    }
    public function status()
    {
        return $this->belongsTo(PostStatus::class, 'post_status_id');
    }
}
