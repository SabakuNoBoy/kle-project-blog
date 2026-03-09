<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $generalError = '';

    public function mount(ApiService $api)
    {
        if ($api->getToken()) {
            return redirect('/');
        }
    }

    public function login(ApiService $api)
    {
        $this->generalError = '';
        $this->resetErrorBag();

        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = $api->post('login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        // Connection or server error
        if (isset($response['error'])) {
            $this->generalError = $response['error'];
            return;
        }

        // Successful login
        if (isset($response['data']['token'])) {
            $api->setToken($response['data']['token']);
            return redirect('/');
        }

        // Backend validation errors (per-field)
        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
            return;
        }

        // General backend error
        $this->generalError = $response['message'] ?? 'Giriş başarısız. Lütfen tekrar deneyin.';
    }

    public function render()
    {
        return view('livewire.login')
            ->layout('components.layouts.app');
    }
}
