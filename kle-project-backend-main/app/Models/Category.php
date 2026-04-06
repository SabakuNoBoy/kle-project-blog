<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Traits\LogsActivity;

class Category extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'slug'];

    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
