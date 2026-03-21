<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_url',
        'thumbnail_url',
        'caption',
        'category',
        'music_name',
        'likes_count',
        'comments_count',
        'reposts_count',
        'shares_count',
        'bookmarks_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reposts()
    {
        return $this->hasMany(Repost::class);
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
