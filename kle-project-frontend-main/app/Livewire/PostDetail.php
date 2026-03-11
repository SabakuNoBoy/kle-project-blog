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
        $this->isLoggedIn = (bool) $api->getToken();
        $this->loadPost($api);
    }

    public function loadPost(ApiService $api)
    {
        $response = $api->get("posts/{$this->slug}");

        // New API format: { data: {...}, message: "..." }
        if (isset($response['data'])) {
            $this->post = $response['data'];
        } elseif (isset($response['id']) || isset($response['slug'])) {
            // Fallback for old format
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

        $response = $api->post('comments', [
            'content' => $this->commentContent,
            'post_id' => $this->post['id'],
        ]);

        if (isset($response['data']['id'])) {
            session()->flash('comment_success', 'Yorumunuz başarıyla gönderildi.');
            $this->commentContent = '';
            $this->loadPost($api);
        } else {
            $this->addError('comment_error', $response['message'] ?? 'Yorum gönderilirken bir hata oluştu.');
        }
    }

    public function toggleLike(ApiService $api)
    {
        if (!$this->isLoggedIn) {
            return redirect('/login');
        }

        $response = $api->post("posts/{$this->post['id']}/like");

        if (isset($response['data'])) {
            $this->loadPost($api);
        }
    }

    public function render()
    {
        return view('livewire.post-detail')
            ->layout('components.layouts.app');
    }
}
