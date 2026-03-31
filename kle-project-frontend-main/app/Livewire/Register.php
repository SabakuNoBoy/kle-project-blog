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



        $response = $api->post('register', [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);

        // Connection or server error
        if (isset($response['error'])) {
            $this->generalError = $response['error'];
            $this->dispatch('swal', [
                'title' => 'Sistem Hatası',
                'text' => $this->generalError,
                'icon' => 'error',
            ]);
            return;
        }

        // Successful register
        if (isset($response['data']['token'])) {
            $api->setToken($response['data']['token']);
            return redirect('/');
        }

        // Backend per-field validation errors
        if (isset($response['errors'])) {
            $firstError = '';
            foreach ($response['errors'] as $field => $messages) {
                $msg = $messages[0];
                $this->addError($field, $msg);
                if (empty($firstError)) $firstError = $msg;
            }
            $this->dispatch('swal', [
                'title' => 'Kayıt Hatası',
                'text' => $firstError,
                'icon' => 'error',
            ]);
            return;
        }

        $this->generalError = $response['message'] ?? 'Kayıt başarısız. Lütfen tekrar deneyin.';
        $this->dispatch('swal', [
            'title' => 'Hata',
            'text' => $this->generalError,
            'icon' => 'error',
        ]);
    }

    public function render()
    {
        return view('livewire.register')
            ->layout('components.layouts.app');
    }
}
