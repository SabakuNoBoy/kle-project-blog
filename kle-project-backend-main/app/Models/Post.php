<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Traits\LogsActivity;

class Post extends Model
{
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'image_url',
        'is_approved'
    ];

    protected static function booted()
    {
        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->user_id) && auth()->check()) {
                $post->user_id = auth()->id();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}
