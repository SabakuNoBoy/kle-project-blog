<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    public function show($slug)
    {
        $category = Category::with([
            'posts' => function ($query) {
                $query->where('is_approved', true)->with('user')->latest();
            }
        ])->where('slug', $slug)->firstOrFail();

        return response()->json($category);
    }
}
