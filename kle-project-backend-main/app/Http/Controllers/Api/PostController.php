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

            return ApiResponse::success(PostResource::collection($posts)->response()->getData(true));
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve posts.', 500);
        }
    }

    public function show($slug)
    {
        try {
            $post = Post::with([
                'user',
                'category',
                'comments' => function ($q) {
                    $q->where('is_approved', true)->with('user')->latest();
                }
            ])->where('slug', $slug)
                ->where('is_approved', true)
                ->firstOrFail();

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

    public function userPosts(Request $request)
    {
        try {
            $posts = $this->postService->userPosts($request->user());
            return ApiResponse::success(PostResource::collection($posts));
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve your posts.', 500);
        }
    }
}
