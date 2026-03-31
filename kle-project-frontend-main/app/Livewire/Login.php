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
            $firstError = '';
            foreach ($response['errors'] as $field => $messages) {
                $msg = is_array($messages) ? $messages[0] : $messages;
                $this->addError($field, $msg);
                if (empty($firstError)) {
                    $firstError = $msg;
                }
            }

            $this->dispatch('swal', [
                'title' => 'Giriş Hatası',
                'text' => $firstError,
                'icon' => 'error',
                'redirect' => '/' // Yönlendirme eklendi
            ]);
            return;
        }

        // General backend error
        $this->generalError = $response['message'] ?? 'Giriş başarısız. Lütfen tekrar deneyin.';
        $this->dispatch('swal', [
            'title' => 'Hata',
            'text' => $this->generalError,
            'icon' => 'error',
            'redirect' => '/' // Yönlendirme eklendi
        ]);
    }

    public function render()
    {
        return view('livewire.login')
            ->layout('components.layouts.app');
    }
}
