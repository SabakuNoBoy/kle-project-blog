<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostEdit extends Component
{
    use WithFileUploads;

    public $postId;
    public $title;
    public $content;
    public $category_id;
    public $image;
    public $existingImageUrl;
    public $categories = [];
    public $isSuccess = false;

    public function mount(ApiService $api, $id)
    {
        if (!$api->getToken()) {
            return redirect('/login');
        }

        $this->postId = $id;

        // Fetch categories
        $catResponse = $api->get('categories');
        $this->categories = $catResponse['data'] ?? [];

        // Fetch post data
        // For now we use the public 'show' endpoint if we have the slug, or we might need a specific 'edit' data endpoint.
        // Usually it's better to fetch by ID if possible, but our API uses slug mostly.
        // Let's assume we pass the ID to mount and we need to fetch it.
        // Searching for post by ID isn't directly exposed besides userPosts list.
        // Let's try to find it in the user's posts.
        $userPosts = $api->get('user/posts');
        $post = collect($userPosts['data'] ?? [])->firstWhere('id', $id);

        if (!$post) {
            session()->flash('error', 'Yazı bulunamadı veya yetkiniz yok.');
            return redirect('/dashboard');
        }

        $this->title = $post['title'];
        $this->content = $post['content'];
        $this->category_id = $post['category']['id'] ?? null;
        $this->existingImageUrl = $post['image_url'] ?? null;
    }

    public function updatePost(ApiService $api)
    {
        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => $this->category_id,
        ];

        // API Service likely needs to be used with postMultipart for images even on update
        // Laravel PUT + Multipart is tricky, so we added a POST route as fallback in api.php
        if ($this->image) {
            $response = $api->postMultipart("posts/{$this->postId}", $data, ['image' => $this->image]);
        } else {
            // Using PUT if no image, or sticking to POST if it works better for multipart sync
            $response = $api->put("posts/{$this->postId}", $data);
        }

        if (isset($response['error'])) {
            $this->addError('form_error', $response['error']);
            return;
        }

        if (isset($response['data']['id']) || (isset($response['status']) && $response['status'] === 'success')) {
            session()->flash('success_popup', 'Yazınız başarıyla güncellenmiştir.');
            return redirect('/dashboard');
        }

        if (isset($response['errors'])) {
            foreach ($response['errors'] as $field => $messages) {
                $this->addError($field, is_array($messages) ? $messages[0] : $messages);
            }
            return;
        }

        $this->addError('form_error', $response['message'] ?? 'Güncelleme başarısız oldu.');
    }

    public function render()
    {
        return view('livewire.post-edit')
            ->layout('components.layouts.app');
    }
}
