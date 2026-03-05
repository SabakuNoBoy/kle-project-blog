<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;

class CategoryDetail extends Component
{
    public $category;
    public $slug;

    public function mount($slug, ApiService $api)
    {
        $this->slug = $slug;
        $this->loadCategory($api);
    }

    public function loadCategory(ApiService $api)
    {
        $response = $api->get("categories/{$this->slug}");

        if (isset($response['id']) || isset($response['slug'])) {
            $this->category = $response;
        } else {
            session()->flash('error', 'Kategori bulunamadı.');
            return redirect('/');
        }
    }

    public function render()
    {
        return view('livewire.category-detail')
            ->layout('components.layouts.app');
    }
}
