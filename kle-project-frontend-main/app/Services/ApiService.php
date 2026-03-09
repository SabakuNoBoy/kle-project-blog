<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('VITE_API_URL', 'http://host.docker.internal:8080/api');
    }

    public function get(string $endpoint, array $query = [])
    {
        return Http::withToken($this->getToken())
            ->acceptJson()
            ->get("{$this->baseUrl}/{$endpoint}", $query)
            ->json();
    }

    public function post(string $endpoint, array $data = [])
    {
        return Http::withToken($this->getToken())
            ->acceptJson()
            ->post("{$this->baseUrl}/{$endpoint}", $data)
            ->json();
    }

    public function postMultipart(string $endpoint, array $data = [], array $files = [])
    {
        $request = Http::withToken($this->getToken())->acceptJson();

        foreach ($files as $key => $file) {
            if ($file) {
                $request->attach($key, file_get_contents($file->getRealPath()), $file->getClientOriginalName());
            }
        }

        return $request->post("{$this->baseUrl}/{$endpoint}", $data)->json();
    }

    public function put(string $endpoint, array $data = [])
    {
        return Http::withToken($this->getToken())
            ->acceptJson()
            ->put("{$this->baseUrl}/{$endpoint}", $data)
            ->json();
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
