<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('has_posts')) {
            $query->whereHas('posts', function ($q) {
                $q->where('is_approved', true);
            });
        }

        return \App\Http\Responses\ApiResponse::success(
            \App\Http\Resources\Api\UserResource::collection($query->get())
        );
    }
}
