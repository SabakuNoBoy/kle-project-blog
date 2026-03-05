<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    public $categories = [];
    public $posts = [];
    public $search = '';
    public $selectedCategory = null;

    public function mount(ApiService $api)
    {
        $this->categories = $api->get('categories') ?? [];
        $this->loadPosts($api);
    }

    public function updatedSearch()
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

        $response = $api->get('posts', $query);
        $this->posts = $response['data'] ?? [];
    }

    public function render()
    {
        return view('livewire.home')
            ->layout('components.layouts.app');
    }
}
