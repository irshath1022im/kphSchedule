<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class DashBoard extends Component
{
    public function render()
    {
        return view('livewire.pages.dash-board')->layout('components.dash-board');
    }
}
