<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount(ApiService $api)
    {
        if ($api->getToken()) {
            return redirect('/');
        }
    }

    public function register(ApiService $api)
    {
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

        if (isset($response['token'])) {
            $api->setToken($response['token']);
            return redirect('/');
        }

        $this->addError('email', $response['message'] ?? 'Registration failed. Please try again.');
    }

    public function render()
    {
        return view('livewire.register')
            ->layout('components.layouts.app');
    }
}
