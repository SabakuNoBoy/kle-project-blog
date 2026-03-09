<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_comments');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): bool
    {
        return $user->hasPermissionTo('view_comments');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can create comments (or public if allowed)
    }

    /**
     * Determine whether the user can update the model (Approve).
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->hasPermissionTo('approve_comments');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->hasPermissionTo('delete_comments') || $user->id === $comment->user_id;
    }
}
