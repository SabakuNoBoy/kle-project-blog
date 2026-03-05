<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;

class Dashboard extends Component
{
    public $user;
    public $posts = [];

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

        // Check if unauthenticated or error
        if (isset($userResponse['message']) || empty($userResponse)) {
            $api->clearToken();
            return redirect('/login');
        }

        $this->user = $userResponse['data'] ?? $userResponse;
        $this->name = $this->user['name'] ?? '';
        $this->email = $this->user['email'] ?? '';

        $postsResponse = $api->get('user/posts');
        $this->posts = is_array($postsResponse) && !isset($postsResponse['message']) ? $postsResponse : [];
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

        if (isset($response['user'])) {
            $this->user = $response['user'];
            session()->flash('success', 'Profil başarıyla güncellendi.');
            $this->password = '';
            $this->password_confirmation = '';
        } else {
            if (isset($response['errors'])) {
                foreach ($response['errors'] as $key => $messages) {
                    $this->addError($key, $messages[0]);
                }
            } else {
                session()->flash('error', $response['message'] ?? 'Bir hata oluştu.');
            }
        }
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('components.layouts.app');
    }
}
