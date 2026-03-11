<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PostLike;
use App\Models\Comment;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles->pluck('name'),
            'stats' => [
                'posts_count' => $this->posts()->count(),
                'likes_count' => PostLike::whereIn('post_id', $this->posts()->pluck('id'))->count(),
                'comments_count' => Comment::whereIn('post_id', $this->posts()->pluck('id'))->count(),
            ],
        ];
    }
}
