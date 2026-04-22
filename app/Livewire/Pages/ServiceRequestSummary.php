<?php

namespace App\Livewire\Pages;

use App\Models\ServiceRequest;
use Livewire\Component;

class ServiceRequestSummary extends Component
{
    public function render()
    {
        $query = ServiceRequest::query()
                    ->with('serviceRequestPeriods', 'assignedMaids', 'serviceCharge', 'client')
                    ->get()
                    ->sortByDesc('id')
                    ->groupBy('frequency')
                    ;

        $lastTransections = clone $query->map(fn($requests) => $requests->take(5));

        return view('livewire.pages.service-request-summary',
        ['serviceRequests' => $lastTransections, 'grouped' => $query])->layout('components.dash-board');
    }
}
