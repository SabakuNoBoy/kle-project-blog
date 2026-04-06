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
                'comments_count' => $this->comments()->count(),
            ],
            'comments' => $this->comments()
                ->with('post:id,title,slug')
                ->latest()
                ->get()
                ->map(fn($comment) => [
                    'id' => $comment->id,
                    'post_title' => $comment->post->title ?? 'Bilinmeyen Yazı',
                    'post_slug' => $comment->post->slug ?? '',
                    'content' => $comment->content,
                    'is_approved' => (bool) $comment->is_approved,
                    'created_at' => $comment->created_at->diffForHumans(),
                ]),
        ];
    }
}
