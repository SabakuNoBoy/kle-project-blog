<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    public function mount(ApiService $api)
    {
        if ($api->getToken()) {
            return redirect('/');
        }
    }

    public function login(ApiService $api)
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = $api->post('login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if (isset($response['token'])) {
            $api->setToken($response['token']);
            return redirect('/');
        }

        $this->addError('email', $response['message'] ?? 'Invalid credentials. Please try again.');
    }

    public function render()
    {
        return view('livewire.login')
            ->layout('components.layouts.app');
    }
}
