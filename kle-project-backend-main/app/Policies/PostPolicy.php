<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('view_posts');
    }

    public function view(User $user, Post $post): bool
    {
        // Admin or with permission or if it's their own post
        return $user->hasRole('admin') || $user->hasPermissionTo('view_posts') || $post->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('create_posts');
    }

    public function update(User $user, Post $post): bool
    {
        // Admin can edit all, others need permission AND must be the author
        if ($user->hasRole('admin')) {
            return true;
        }

        return ($user->id === $post->user_id) && $user->hasPermissionTo('edit_posts');
    }

    public function delete(User $user, Post $post): bool
    {
        // Only Admin or specific permission (usually only for author or high level)
        return $user->hasRole('admin') || $user->hasPermissionTo('delete_posts');
    }
}
