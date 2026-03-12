<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ScheduleSummary extends Component
{
    public function render()
    {
        return view('livewire.pages.schedule-summary')->layout('components.dash-board');
    }
}
