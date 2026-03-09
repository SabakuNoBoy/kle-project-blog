<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * Get all categories.
     */
    public function all(): Collection
    {
        try {
            return Category::all();
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve categories: ' . $e->getMessage());
        }
    }

    /**
     * Get a single category by slug with its approved posts.
     */
    public function findBySlug(string $slug): Category
    {
        try {
            return Category::with([
                'posts' => function ($query) {
                    $query->where('is_approved', true)->with('user')->latest();
                }
            ])->where('slug', $slug)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve category: ' . $e->getMessage());
        }
    }
}
