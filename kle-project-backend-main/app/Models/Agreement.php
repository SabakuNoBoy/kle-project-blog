<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Agreement extends Model
{
    protected $fillable = ['title', 'slug', 'content'];

    protected static function booted()
    {
        static::creating(function ($agreement) {
            if (empty($agreement->slug)) {
                $agreement->slug = Str::slug($agreement->title);
            }
        });
    }
}
