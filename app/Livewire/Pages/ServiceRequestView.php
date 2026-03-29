<?php

namespace App\Livewire\Pages;

use App\Models\ServiceRequest;
use Livewire\Component;

class ServiceRequestView extends Component
{
    public $id;
    public $serviceRequest;

    public function mount($id)
    {
        // Load the service request details using the provided ID
        // You can use Eloquent to fetch the service request and its related periods
        // For example:
        $this->id = $id;

    }

    public function deletePeriod($periodId)
    {
        $period = $this->serviceRequest->serviceRequestPeriods()->findOrFail($periodId);
        $period->delete();

        // Refresh the service request details after deletion

    }

    public function render()
    {
        $this->serviceRequest = ServiceRequest::with('client','serviceRequestPeriods.service', 'assignedMaids')
        ->orderBy('id', 'desc')->findOrFail($this->id);

        return view('livewire.pages.service-request-view', ['serviceRequest' => $this->serviceRequest])->layout('components.dash-board');
    }
}
