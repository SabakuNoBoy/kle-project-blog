<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Responses\ApiResponse;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct(private \App\Services\CategoryService $categoryService)
    {
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->all();
            return ApiResponse::success(CategoryResource::collection($categories));
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve categories.', 500);
        }
    }

    public function show($slug)
    {
        try {
            $category = $this->categoryService->findBySlug($slug);
            return ApiResponse::success(new CategoryResource($category));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return ApiResponse::error('Category not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve category.', 500);
        }
    }
}
