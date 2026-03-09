<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
            ->where('is_approved', true)
            ->latest();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('author_id') && !empty($request->author_id)) {
            $query->where('user_id', $request->author_id);
        }

        if ($request->has('date') && !empty($request->date)) {
            $dateParts = explode('-', $request->date);
            if (count($dateParts) >= 2) {
                $query->whereYear('created_at', $dateParts[0])
                    ->whereMonth('created_at', $dateParts[1]);
            }
        }

        return response()->json($query->paginate(10));
    }

    public function show($slug)
    {
        $post = Post::with([
            'user',
            'category',
            'comments' => function ($q) {
                $q->where('is_approved', true)->with('user')->latest();
            }
        ])->where('slug', $slug)
            ->where('is_approved', true)
            ->firstOrFail();

        return response()->json($post);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->content,
            'image_url' => $imagePath ? '/storage/' . $imagePath : null,
            'is_approved' => false,
        ]);

        return response()->json($post, 201);
    }

    public function userPosts(Request $request)
    {
        $posts = Post::with('category')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($posts);
    }
}

