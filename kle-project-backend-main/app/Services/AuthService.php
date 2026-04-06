<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Register a new user and return user + token.
     */
    public function register(array $data): array
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'is_active' => false,
            ]);

            $user->assignRole('user');

            return [
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ];
        } catch (\Exception $e) {
            throw new \RuntimeException('User registration failed: ' . $e->getMessage());
        }
    }

    /**
     * Attempt login, return user + token or throw validation exception.
     */
    public function login(array $data): array
    {
        try {
            $user = User::where('email', $data['email'])->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => ['User not found.'],
                ]);
            }

            if (!Hash::check($data['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'password' => ['Incorrect password.'],
                ]);
            }

            // Block login if user account is deactivated (Admins bypass this)
            if (!$user->is_active && !$user->hasRole('admin')) {
                throw ValidationException::withMessages([
                    'email' => ['Access denied. Your account is deactivated.'],
                ]);
            }

            return [
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ];
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \RuntimeException('Login failed: ' . $e->getMessage());
        }
    }

    /**
     * Update user profile fields.
     */
    public function update(User $user, array $data): User
    {
        try {
            $user->name = $data['name'];
            $user->email = $data['email'];

            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();

            return $user;
        } catch (\Exception $e) {
            throw new \RuntimeException('Profile update failed: ' . $e->getMessage());
        }
    }
}
