<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostLikeController extends Controller
{
    /**
     * Toggle the like status for a specific post.
     */
    public function toggle(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $user = $request->user();

        // Daha önce beğenilmiş mi kontrol et
        $like = $post->likes()->where('user_id', $user->id)->first();

        if ($like) {
            // Varsa sil (Beğeniyi geri al)
            $like->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Post beğenisi kaldırıldı.',
                'data' => [
                    'is_liked' => false,
                    'likes_count' => $post->likes()->count()
                ]
            ]);
        } else {
            // Yoksa ekle (Beğen)
            $post->likes()->create([
                'user_id' => $user->id
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Post beğenildi.',
                'data' => [
                    'is_liked' => true,
                    'likes_count' => $post->likes()->count()
                ]
            ]);
        }
    }
}
