<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\LogsActivity;

class Comment extends Model
{
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'is_approved'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
