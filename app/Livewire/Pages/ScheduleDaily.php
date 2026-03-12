<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ScheduleDaily extends Component
{
    public function render()
    {
        return view('livewire.pages.schedule-daily')->layout('components.dash-board');
    }
}
