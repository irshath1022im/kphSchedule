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
        $this->serviceRequest = ServiceRequest::with('client','serviceRequestPeriods.service', 'assignedMaids')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.pages.service-request-view')->layout('components.dash-board');
    }
}
