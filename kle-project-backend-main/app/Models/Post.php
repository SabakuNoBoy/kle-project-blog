<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
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

            // Extract first image from content if image_url is empty
            if (empty($post->image_url) && !empty($post->content)) {
                if (preg_match('/<img.+src=["\']([^"\']+)["\']/', $post->content, $matches)) {
                    $post->image_url = $matches[1];
                }
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
}
