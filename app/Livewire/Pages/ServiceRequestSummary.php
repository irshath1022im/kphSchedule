<?php

namespace App\Livewire\Pages;

use App\Models\ServiceRequest;
use Livewire\Component;

class ServiceRequestSummary extends Component
{
    public function render()
    {
        $query = ServiceRequest::query()
                    ->with('serviceRequestPeriods', 'assignedMaids')
                    ->get()
                    ->sortByDesc('service_request_date');

        return view('livewire.pages.service-request-summary',
        ['serviceRequests' => $query])->layout('components.dash-board');
    }
}
