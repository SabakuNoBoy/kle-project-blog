<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\CommentResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'image_url' => \Illuminate\Support\Facades\Storage::disk('public')->url($this->image_url ?: 'posts/default.svg'),
            'is_approved' => $this->is_approved,
            'likes_count' => $this->likes()->count(),
            'is_liked' => auth('sanctum')->check() ? $this->likes()->where('user_id', auth('sanctum')->id())->exists() : false,
            'comments_count' => $this->comments()->count(),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'user' => $this->whenLoaded('user', fn() => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ]),
            'category' => $this->whenLoaded('category', fn() => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ]),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
