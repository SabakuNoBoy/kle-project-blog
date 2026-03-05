<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;

class AgreementDetail extends Component
{
    public $agreement;
    public $slug;

    public function mount($slug, ApiService $api)
    {
        $this->slug = $slug;
        $response = $api->get("agreements/{$this->slug}");

        if (isset($response['id']) || isset($response['slug'])) {
            $this->agreement = $response;
        } else {
            return redirect('/');
        }
    }

    public function render()
    {
        return view('livewire.agreement-detail')
            ->layout('components.layouts.app');
    }
}
