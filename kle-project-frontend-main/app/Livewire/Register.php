<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $generalError = '';

    public function mount(ApiService $api)
    {
        if ($api->getToken()) {
            return redirect('/');
        }
    }

    public function register(ApiService $api)
    {
        $this->generalError = '';
        $this->resetErrorBag();

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $response = $api->post('register', [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);

        // Connection or server error
        if (isset($response['error'])) {
            $this->generalError = $response['error'];
            return;
        }

        // Successful register
        if (isset($response['data']['token'])) {
            $api->setToken($response['data']['token']);
            return redirect('/');
        }

        // Backend per-field validation errors
        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
            return;
        }

        $this->generalError = $response['message'] ?? 'Kayıt başarısız. Lütfen tekrar deneyin.';
    }

    public function render()
    {
        return view('livewire.register')
            ->layout('components.layouts.app');
    }
}
