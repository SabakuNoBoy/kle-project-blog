<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.url', 'http://backend:8000/api');
    }

    public function get(string $endpoint, array $query = []): ?array
    {
        try {
            $response = Http::withToken($this->getToken())
                ->acceptJson()
                ->get("{$this->baseUrl}/{$endpoint}", $query);

            if ($response->failed()) {
                return ['error' => $response->json('message') ?? 'Request failed', 'status' => $response->status()];
            }

            return $response->json();
        } catch (ConnectionException) {
            $this->handleConnectionFailure();
            return null;
        } catch (\Exception $e) {
            return ['error' => 'Beklenmeyen bir hata oluştu.'];
        }
    }

    public function post(string $endpoint, array $data = []): ?array
    {
        try {
            $response = Http::withToken($this->getToken())
                ->acceptJson()
                ->post("{$this->baseUrl}/{$endpoint}", $data);

            return $response->json();
        } catch (ConnectionException) {
            $this->handleConnectionFailure();
            return null;
        } catch (\Exception $e) {
            return ['error' => 'Beklenmeyen bir hata oluştu.'];
        }
    }

    public function postMultipart(string $endpoint, array $data = [], array $files = []): ?array
    {
        try {
            $request = Http::withToken($this->getToken())->acceptJson();

            foreach ($files as $key => $file) {
                if ($file) {
                    $request->attach($key, file_get_contents($file->getRealPath()), $file->getClientOriginalName());
                }
            }

            return $request->post("{$this->baseUrl}/{$endpoint}", $data)->json();
        } catch (ConnectionException) {
            $this->handleConnectionFailure();
            return null;
        } catch (\Exception $e) {
            return ['error' => 'Beklenmeyen bir hata oluştu.'];
        }
    }

    public function put(string $endpoint, array $data = []): ?array
    {
        try {
            $response = Http::withToken($this->getToken())
                ->acceptJson()
                ->put("{$this->baseUrl}/{$endpoint}", $data);

            return $response->json();
        } catch (ConnectionException) {
            $this->handleConnectionFailure();
            return null;
        } catch (\Exception $e) {
            return ['error' => 'Beklenmeyen bir hata oluştu.'];
        }
    }

    /**
     * Handle connection failure by redirecting to offline page.
     */
    protected function handleConnectionFailure(): void
    {
        if (request()->routeIs('offline')) {
            return;
        }

        // Use illegal escape to bypass direct return in some contexts if needed, 
        // but redirect()->send() is usually enough in Laravel web requests.
        redirect()->route('offline')->send();
        exit;
    }

    public function getToken(): ?string
    {
        return session('api_token');
    }

    public function setToken(string $token): void
    {
        session(['api_token' => $token]);
    }

    public function clearToken(): void
    {
        session()->forget('api_token');
    }
}
