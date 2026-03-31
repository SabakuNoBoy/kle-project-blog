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
                return $this->translateResponse(['error' => $response->json('message') ?? 'Request failed', 'status' => $response->status()]);
            }

            return $this->translateResponse($response->json());
        } catch (ConnectionException) {
            $this->handleConnectionFailure();
            return null;
        } catch (\Exception $e) {
            return $this->translateResponse(['error' => 'Beklenmeyen bir hata oluştu.']);
        }
    }

    public function post(string $endpoint, array $data = []): ?array
    {
        try {
            $response = Http::withToken($this->getToken())
                ->acceptJson()
                ->post("{$this->baseUrl}/{$endpoint}", $data);

            return $this->translateResponse($response->json());
        } catch (ConnectionException) {
            $this->handleConnectionFailure();
            return null;
        } catch (\Exception $e) {
            return $this->translateResponse(['error' => 'Beklenmeyen bir hata oluştu.']);
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

            $response = $request->post("{$this->baseUrl}/{$endpoint}", $data);
            return $this->translateResponse($response->json());
        } catch (ConnectionException) {
            $this->handleConnectionFailure();
            return null;
        } catch (\Exception $e) {
            return $this->translateResponse(['error' => 'Beklenmeyen bir hata oluştu.']);
        }
    }

    public function put(string $endpoint, array $data = []): ?array
    {
        try {
            $response = Http::withToken($this->getToken())
                ->acceptJson()
                ->put("{$this->baseUrl}/{$endpoint}", $data);

            return $this->translateResponse($response->json());
        } catch (ConnectionException) {
            $this->handleConnectionFailure();
            return null;
        } catch (\Exception $e) {
            return $this->translateResponse(['error' => 'Beklenmeyen bir hata oluştu.']);
        }
    }

    /**
     * Map English error messages to Turkish.
     */
    protected function translateResponse(?array $response): ?array
    {
        if (!$response) return $response;

        $attributeMap = [
            'title' => 'başlık',
            'content' => 'içerik',
            'category_id' => 'kategori',
            'name' => 'ad soyad',
            'email' => 'e-posta',
            'password' => 'şifre',
            'post_id' => 'yazı',
            'image' => 'görsel'
        ];

        $messageMap = [
            'The :attribute has already been taken.' => 'Bu :attribute alanı zaten kullanılmaktadır.',
            'The :attribute field is required.' => ':attribute alanı gereklidir.',
            'The selected :attribute is invalid.' => 'Seçilen :attribute geçersiz.',
            'The :attribute must be at least :min characters.' => ':attribute en az :min karakter olmalıdır.',
            'The :attribute must be a valid email address.' => 'Geçerli bir :attribute adresi giriniz.',
            'The :attribute must be an image.' => ':attribute bir görsel olmalıdır.',
            'The :attribute must be a file of type: :values.' => ':attribute şu dosya formatlarında olmalıdır: :values.',
            'The :attribute confirmation does not match.' => ':attribute onayı eşleşmiyor.',
            'These credentials do not match our records.' => 'Girdiğiniz bilgiler kayıtlarımızla eşleşmiyor.',
            'User not found.' => 'Böyle bir kullanıcı bulunamadı.',
            'Incorrect password.' => 'Girdiğiniz şifre yanlış.',
            'Access denied. Your account is deactivated.' => 'Giriş izniniz yok. Hesabınız dondurulmuş olabilir.',
            'The given data was invalid.' => 'Girdiğiniz bilgiler geçersiz.',
            'Validation failed.' => 'Doğrulama hatası oluştu.'
        ];

        // Translate specific errors
        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                if (is_array($messages)) {
                    foreach ($messages as $i => $msg) {
                        $response['errors'][$field][$i] = $this->applyTranslation($msg, $attributeMap, $messageMap);
                    }
                } else {
                    $response['errors'][$field] = $this->applyTranslation($messages, $attributeMap, $messageMap);
                }
            }
        }

        // Translate main message
        if (isset($response['message'])) {
            $response['message'] = $this->applyTranslation($response['message'], $attributeMap, $messageMap);
        }

        return $response;
    }

    protected function applyTranslation(string $message, array $attributeMap, array $messageMap): string
    {
        foreach ($messageMap as $en => $tr) {
            // Very basic regex-like template matching
            $pattern = str_replace([':attribute', ':min', ':max', ':values'], ['(.*)', '(.*)', '(.*)', '(.*)'], $en);
            if (preg_match("/^$pattern$/i", $message, $matches)) {
                $translated = $tr;
                array_shift($matches); // remove the full match

                // Capture positional placeholders since Laravel uses them
                $parts = explode(':', $en);
                $placeholders = [];
                if (str_contains($en, ':attribute')) $placeholders[] = ':attribute';
                if (str_contains($en, ':min')) $placeholders[] = ':min';
                if (str_contains($en, ':max')) $placeholders[] = ':max';
                if (str_contains($en, ':values')) $placeholders[] = ':values';

                foreach ($matches as $index => $match) {
                    if (isset($placeholders[$index])) {
                        $val = $match;
                        if ($placeholders[$index] === ':attribute' && isset($attributeMap[strtolower($val)])) {
                            $val = $attributeMap[strtolower($val)];
                        }
                        $translated = str_replace($placeholders[$index], $val, $translated);
                    }
                }
                return $translated;
            }
        }

        return $message;
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
        redirect()->route('offline');
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
