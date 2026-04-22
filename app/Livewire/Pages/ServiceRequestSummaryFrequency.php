<?php

namespace App\Livewire\Pages;

use App\Models\ServiceRequest;
use Livewire\Component;

class ServiceRequestSummaryFrequency extends Component
{

    public $frequency;

    public function mount($frequency)
    {
        $this->frequency = $frequency;
    }

    public function render()
    {

        $query = ServiceRequest::query()
                    ->with('serviceRequestPeriods', 'assignedMaids', 'serviceCharge', 'client')
                    ->where('frequency', $this->frequency)
                    ->get()
                    ->sortByDesc('id')
                    ;
        return view('livewire.pages.service-request-summary-frequency', ['serviceRequests' => $query])->layout('components.dash-board');
    }
}
