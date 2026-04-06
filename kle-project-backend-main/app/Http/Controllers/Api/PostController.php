<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Resources\Api\PostResource;
use App\Http\Responses\ApiResponse;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostService $postService)
    {
    }

    public function index(Request $request)
    {
        try {
            $posts = $this->postService->index($request->only(['search', 'category', 'author_id', 'date']));

            return ApiResponse::success([
                'items' => PostResource::collection($posts)->resolve(),
                'meta' => [
                    'total' => $posts->total(),
                    'per_page' => $posts->perPage(),
                    'current_page' => $posts->currentPage(),
                    'last_page' => $posts->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve posts.', 500);
        }
    }

    public function show($slug)
    {
        try {
            $post = $this->postService->findBySlug($slug);
            return ApiResponse::success(new PostResource($post));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return ApiResponse::error('Post not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve post.', 500);
        }
    }

    public function store(StorePostRequest $request)
    {
        try {
            $post = $this->postService->store(
                $request->validated(),
                $request->user(),
                $request->file('image')
            );

            return ApiResponse::created(new PostResource($post), 'Post created and pending approval.');
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to create post.', 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->user_id !== $request->user()->id && !$request->user()->hasRole('admin')) {
                return ApiResponse::error('Unauthorized.', 403);
            }

            $validated = $request->validate([
                'category_id' => 'sometimes|required|exists:categories,id',
                'title' => 'sometimes|required|string|max:255',
                'content' => 'sometimes|required|string',
                'image' => 'nullable|image|max:5120',
            ]);

            $post = $this->postService->update(
                $post,
                $validated,
                $request->file('image')
            );

            return ApiResponse::success(new PostResource($post), 'Post updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Post not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to update post: ' . $e->getMessage(), 500);
        }
    }

    public function userPosts(Request $request)
    {
        try {
            $posts = $this->postService->userPosts($request->user());
            return ApiResponse::success(PostResource::collection($posts));
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve your posts.', 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->user_id !== $request->user()->id && !$request->user()->hasRole('admin')) {
                return ApiResponse::error('Unauthorized.', 403);
            }

            $this->postService->delete($post);

            return ApiResponse::success(null, 'Post deleted successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Post not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to delete post: ' . $e->getMessage(), 500);
        }
    }
}
