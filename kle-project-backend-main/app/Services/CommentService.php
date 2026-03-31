<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentService
{
    /**
     * Store a new comment, ensuring the post is approved.
     */
    public function store(array $data, User $user): Comment
    {
        try {
            $post = Post::find($data['post_id']);

            if (!$post || !$post->is_approved) {
                throw new \InvalidArgumentException('You cannot comment on an unapproved post.');
            }

            return Comment::create([
                'user_id' => $user->id,
                'post_id' => $data['post_id'],
                'content' => $data['content'],
                'is_approved' => false,
            ]);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to create comment: ' . $e->getMessage());
        }
    }
}
