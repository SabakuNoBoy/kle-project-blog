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
        $this->categories = $catResponse ?? [];
    }

    public function createPost(ApiService $api)
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required',
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => $this->category_id,
        ];

        $response = $api->post('posts', $data);

        // Treat it as successful if it doesn't have an explicit 'message' indicating a 422/401
        // OR if it has an id
        if (isset($response['id']) || isset($response['data']['id']) || (!isset($response['message']) && is_array($response))) {
            session()->flash('success_popup', 'Yayınlama talebiniz alınmıştır.');
            $this->isSuccess = true;
            return redirect('/');
        }

        // If validation error from API
        if (isset($response['message'])) {
            $this->addError('form_error', $response['message']);
            return;
        }

        $this->addError('form_error', 'Yazı eklenirken sunucuda bir hata oluştu.');
    }

    public function render()
    {
        return view('livewire.post-create')
            ->layout('components.layouts.app');
    }
}
