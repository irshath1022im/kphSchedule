<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ClientsSummary extends Component
{
    public function render()
    {
        return view('livewire.pages.clients-summary')->layout('components.dash-board');
    }
}
