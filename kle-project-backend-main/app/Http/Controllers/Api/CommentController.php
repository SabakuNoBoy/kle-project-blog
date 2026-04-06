<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCommentRequest;
use App\Http\Resources\Api\CommentResource;
use App\Http\Responses\ApiResponse;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService)
    {
    }

    public function store(StoreCommentRequest $request)
    {
        try {
            $comment = $this->commentService->store($request->validated(), $request->user());

            return ApiResponse::created(new CommentResource($comment), 'Comment posted successfully.');
        } catch (\InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to post comment.', 500);
        }
    }
}
