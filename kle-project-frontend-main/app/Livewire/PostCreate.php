<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostCreate extends Component
{
    use WithFileUploads;

    public $title;
    public $content;
    public $category_id;
    public $image;
    public $categories = [];
    public $isSuccess = false;

    public function mount(ApiService $api)
    {
        if (!$api->getToken()) {
            return redirect('/login');
        }
        $catResponse = $api->get('categories');
        $this->categories = $catResponse['data'] ?? [];
    }

    public function updatedImage()
    {
        // Frontend validation removed to rely solely on backend
    }

    public function createPost(ApiService $api)
    {


        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => $this->category_id,
        ];

        if ($this->image) {
            $response = $api->postMultipart('posts', $data, ['image' => $this->image]);
        } else {
            $response = $api->post('posts', $data);
        }

        // Connection or generic error check
        if (isset($response['error'])) {
            $this->addError('form_error', $response['error']);
            return;
        }

        // Success condition: check for ID or success status
        if (isset($response['id']) || isset($response['data']['id']) || (isset($response['status']) && $response['status'] === 'success')) {
            session()->flash('success_popup', 'Yayınlama talebiniz alınmıştır.');
            $this->isSuccess = true;
            return redirect('/');
        }

        // Backend validation errors (422)
        if (isset($response['errors'])) {
            $firstError = '';
            foreach ($response['errors'] as $field => $messages) {
                $msg = is_array($messages) ? $messages[0] : $messages;
                $this->addError($field, $msg);
                if (empty($firstError)) $firstError = $msg;
            }
            
            $this->dispatch('swal', [
                'title' => 'Doğrulama Hatası',
                'text' => $firstError,
                'icon' => 'error',
            ]);
            return;
        }

        // Fallback error message
        if (isset($response['message'])) {
            $msg = $response['message'];
            $this->addError('form_error', $msg);
            $this->dispatch('swal', [
                'title' => 'Hata',
                'text' => $msg,
                'icon' => 'error',
            ]);
            return;
        }

        $this->addError('form_error', 'Beklenmedik bir hata oluştu.');
        $this->dispatch('swal', [
            'title' => 'Sistem Hatası',
            'text' => 'Bilinmeyen bir hata oluştu, lütfen daha sonra tekrar deneyin.',
            'icon' => 'error',
        ]);
    }

    public function render()
    {
        return view('livewire.post-create')
            ->layout('components.layouts.app');
    }
}
