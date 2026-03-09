<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;

class PostService
{
    /**
     * Get filtered + paginated list of approved posts.
     */
    public function index(array $filters = [])
    {
        try {
            $query = Post::with(['user', 'category'])
                ->where('is_approved', true)
                ->latest();

            if (!empty($filters['search'])) {
                $query->where('title', 'like', '%' . $filters['search'] . '%');
            }

            if (!empty($filters['category'])) {
                $query->whereHas('category', function ($q) use ($filters) {
                    $q->where('slug', $filters['category']);
                });
            }

            if (!empty($filters['author_id'])) {
                $query->where('user_id', $filters['author_id']);
            }

            if (!empty($filters['date'])) {
                $parts = explode('-', $filters['date']);
                if (count($parts) >= 2) {
                    $query->whereYear('created_at', $parts[0])
                        ->whereMonth('created_at', $parts[1]);
                }
            }

            return $query->paginate(10);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve posts: ' . $e->getMessage());
        }
    }

    /**
     * Create a new post for the given user.
     */
    public function store(array $data, User $user, $imageFile = null): Post
    {
        try {
            $imagePath = null;
            if ($imageFile) {
                $imagePath = $imageFile->store('posts', 'public');
            }

            return Post::create([
                'user_id' => $user->id,
                'category_id' => $data['category_id'],
                'title' => $data['title'],
                'content' => $data['content'],
                'image_url' => $imagePath ? '/storage/' . $imagePath : null,
                'is_approved' => false,
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to create post: ' . $e->getMessage());
        }
    }

    /**
     * Get all posts belonging to the given user.
     */
    public function userPosts(User $user)
    {
        try {
            return Post::with('category')
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve user posts: ' . $e->getMessage());
        }
    }
}
