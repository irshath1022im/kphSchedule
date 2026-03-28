<?php

namespace App\Livewire\Pages;

use App\Models\ServiceRequest;
use Livewire\Component;

class ServiceRequestSummary extends Component
{
    public function render()
    {
        $query = ServiceRequest::query()
                    ->with('serviceRequestPeriods');
        return view('livewire.pages.service-request-summary',
        ['serviceRequests' => $query->get()])->layout('components.dash-board');
    }
}
