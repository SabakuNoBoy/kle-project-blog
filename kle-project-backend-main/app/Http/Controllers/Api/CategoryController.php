<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Responses\ApiResponse;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            return ApiResponse::success(CategoryResource::collection($categories));
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve categories.', 500);
        }
    }

    public function show($slug)
    {
        try {
            $category = Category::with([
                'posts' => function ($query) {
                    $query->where('is_approved', true)->with('user')->latest();
                }
            ])->where('slug', $slug)->firstOrFail();

            return ApiResponse::success(new CategoryResource($category));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return ApiResponse::error('Category not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve category.', 500);
        }
    }
}
