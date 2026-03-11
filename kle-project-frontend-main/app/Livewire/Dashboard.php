<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;

class Dashboard extends Component
{
    public $user;
    public $posts = [];
    public $stats = [
        'posts_count' => 0,
        'likes_count' => 0,
        'comments_count' => 0,
    ];

    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount(ApiService $api)
    {
        if (!$api->getToken()) {
            return redirect('/login');
        }

        $userResponse = $api->get('user');

        // New API format: { data: {...}, message: "..." }
        $userData = $userResponse['data'] ?? null;

        if (!$userData || isset($userResponse['error'])) {
            $api->clearToken();
            return redirect('/login');
        }

        $this->user = $userData;
        $this->name = $this->user['name'] ?? '';
        $this->email = $this->user['email'] ?? '';
        $this->stats = $this->user['stats'] ?? $this->stats;

        $postsResponse = $api->get('user/posts');
        $this->posts = $postsResponse['data'] ?? [];
    }

    public function updateProfile(ApiService $api)
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if (!empty($this->password)) {
            $data['password'] = $this->password;
            $data['password_confirmation'] = $this->password_confirmation;
        }

        $response = $api->put('user', $data);

        // New format: { data: { user: {...} }, message: "..." }
        if (isset($response['data']['id'])) {
            $this->user = $response['data'];
            session()->flash('success', 'Profil başarıyla güncellendi.');
            $this->password = '';
            $this->password_confirmation = '';
        } elseif (isset($response['errors'])) {
            foreach ($response['errors'] as $key => $messages) {
                $this->addError($key, $messages[0]);
            }
        } else {
            session()->flash('error', $response['message'] ?? 'Bir hata oluştu.');
        }
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('components.layouts.app');
    }
}
