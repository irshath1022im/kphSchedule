<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ServiceRequestSummary extends Component
{
    public function render()
    {
        return view('livewire.pages.service-request-summary')->layout('components.dash-board');
    }
}
