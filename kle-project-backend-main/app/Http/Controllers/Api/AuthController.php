<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Resources\Api\UserResource;
use App\Http\Responses\ApiResponse;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function register(RegisterRequest $request)
    {
        try {
            $result = $this->authService->register($request->validated());

            return ApiResponse::created([
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ], 'User registered successfully.');
        } catch (\Exception $e) {
            return ApiResponse::error('Registration failed. Please try again.', 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $result = $this->authService->login($request->validated());

            return ApiResponse::success([
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ], 'Login successful.');
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return ApiResponse::error('Login failed. Please try again.', 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return ApiResponse::success(null, 'Logged out successfully.');
        } catch (\Exception $e) {
            return ApiResponse::error('Logout failed.', 500);
        }
    }

    public function user(Request $request)
    {
        return ApiResponse::success(new UserResource($request->user()));
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            $user = $this->authService->update($request->user(), $request->validated());

            return ApiResponse::success(new UserResource($user), 'Profile updated successfully.');
        } catch (\Exception $e) {
            return ApiResponse::error('Profile update failed.', 500);
        }
    }
}
