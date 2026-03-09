<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    public $categories = [];
    public $authors = [];
    public $posts = [];
    public $search = '';
    public $error = '';
    public $selectedCategory = null;
    public $selectedAuthor = null;
    public $selectedDate = null;


    public function mount(ApiService $api)
    {
        $categoriesResponse = $api->get('categories');
        $this->categories = $categoriesResponse['data'] ?? [];

        $authorsResponse = $api->get('users');
        $this->authors = $authorsResponse['data'] ?? [];

        $this->loadPosts($api);
    }


    public function updatedSearch()
    {
        $this->loadPosts(app(ApiService::class));
    }

    public function updatedSelectedAuthor()
    {
        $this->loadPosts(app(ApiService::class));
    }

    public function updatedSelectedDate()
    {
        $this->loadPosts(app(ApiService::class));
    }



    public function setCategory($slug)
    {
        $this->selectedCategory = $slug;
        $this->loadPosts(app(ApiService::class));
    }

    public function loadPosts(ApiService $api)
    {
        $query = [
            'search' => $this->search,
        ];

        if ($this->selectedCategory) {
            $query['category'] = $this->selectedCategory;
        }

        if ($this->selectedAuthor) {
            $query['author_id'] = $this->selectedAuthor;
        }

        if ($this->selectedDate) {
            $query['date'] = $this->selectedDate;
        }



        $response = $api->get('posts', $query);

        if (isset($response['error'])) {
            $this->error = $response['error'];
            $this->posts = [];
        } else {
            $this->error = '';
            // New format: { message, data: { items: [...], meta: {...} } }
            $this->posts = $response['data']['items'] ?? [];
        }
    }

    public function render()
    {
        return view('livewire.home')
            ->layout('components.layouts.app');
    }
}
