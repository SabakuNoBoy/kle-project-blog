<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;

class PostDetail extends Component
{
    public $slug;
    public $post;

    // Comment Data
    public $commentContent;
    public $isLoggedIn = false;

    public function mount($slug, ApiService $api)
    {
        $this->slug = $slug;
        $this->isLoggedIn = $api->getToken() ? true : false;
        $this->loadPost($api);
    }

    public function loadPost(ApiService $api)
    {
        $response = $api->get("posts/{$this->slug}");

        if (isset($response['id']) || isset($response['slug'])) {
            $this->post = $response;
        } else {
            session()->flash('error', 'Yazı bulunamadı.');
            return redirect('/');
        }
    }

    public function submitComment(ApiService $api)
    {
        if (!$this->isLoggedIn) {
            return redirect('/login');
        }

        $this->validate([
            'commentContent' => 'required|string|min:3',
        ]);

        $response = $api->post('comments', [
            'content' => $this->commentContent,
            'post_id' => $this->post['id'],
        ]);

        if (isset($response['id']) || isset($response['data']['id'])) {
            session()->flash('comment_success', 'Yorumunuz başarıyla gönderildi ve onay bekliyor.');
            $this->commentContent = '';
        } else {
            $this->addError('comment_error', 'Yorum gönderilirken bir hata oluştu.');
        }
    }

    public function render()
    {
        return view('livewire.post-detail')
            ->layout('components.layouts.app');
    }
}
