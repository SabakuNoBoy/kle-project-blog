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
                ->withCount(['comments' => fn($q) => $q->where('is_approved', true)])
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
                $date = trim($filters['date']);
                if ($date !== '') {
                    $parts = explode('-', $date);
                    if (count($parts) >= 2) {
                        $query->whereYear('created_at', $parts[0])
                            ->whereMonth('created_at', $parts[1]);
                    }
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
                'image_url' => $imagePath,
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

    /**
     * Update an existing post.
     */
    public function update(Post $post, array $data, $imageFile = null): Post
    {
        try {
            if ($imageFile) {
                // Potential TODO: Delete old image
                $imagePath = $imageFile->store('posts', 'public');
                $data['image_url'] = $imagePath;
            }

            // If title changes, slug should be updated (handled by model booted event usually, 
            // but let's be sure or let it re-slug if title is present)

            $post->update($data);

            return $post->fresh();
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to update post: ' . $e->getMessage());
        }
    }

    /**
     * Get a single post by slug, with approved comments.
     */
    public function findBySlug(string $slug): Post
    {
        try {
            return Post::with([
                'user',
                'category',
                'comments' => function ($q) {
                    $q->where('is_approved', true)->with('user')->latest();
                }
            ])->where('slug', $slug)
                ->where('is_approved', true)
                ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve post: ' . $e->getMessage());
        }
    }
}
