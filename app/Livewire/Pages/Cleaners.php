<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Cleaners extends Component
{
    public function render()
    {
        return view('livewire.pages.cleaners')->layout('components.dash-board');
    }
}
