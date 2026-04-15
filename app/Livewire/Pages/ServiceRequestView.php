<?php

namespace App\Livewire\Pages;

use App\Models\ServiceRequest;
use Livewire\Attributes\On;
use Livewire\Component;

class ServiceRequestView extends Component
{
    public $id; //service request id passed from the route
    public $serviceRequest;
    public $showScheduleModal = false;
    public $showAssignCleanerModal = false;




    public function mount($id)
    {
        // Load the service request details using the provided ID
        // You can use Eloquent to fetch the service request and its related periods
        // For example:
        $this->id = $id;

    }

    public function assignCleanerToAll($service_request_id)
    {
        // Logic to assign a cleaner to all service request periods
        // You can set properties to show an assign cleaner form/modal and populate it with the service request details
        $this->showAssignCleanerModal = true;
        $this->dispatch('assignCleaner',['service_request_id' => $service_request_id]);

    }

    public function assignCleaner($periodId) //for individual period assignment
    {
        // Logic to assign a cleaner to the service request period
        // You can set properties to show an assign cleaner form/modal and populate it with the period details
        $this->showAssignCleanerModal = true;
       $this->dispatch('assignCleaner',['period_id' => $periodId]);

    }

    public function deletePeriod($periodId)
    {
        $period = $this->serviceRequest->serviceRequestPeriods()->findOrFail($periodId);
        $period->delete();

        // Refresh the service request details after deletion

    }

    public function editPeriod($periodId)
    {
        // Logic to edit the service request period
        // You can set properties to show an edit form/modal and populate it with the period details
        $this->showScheduleModal = true;
        $editServiceRequestPeriod = $this->serviceRequest->serviceRequestPeriods()->findOrFail($periodId);
        $this->dispatch('editServiceRequestPeriod', $editServiceRequestPeriod);

    }

    public function closeModal()
    {
        $this->showScheduleModal = false;
        $this->dispatch('closeScheduleModal');
    }

    public function closeAssignCleanerModal()
    {
        $this->showAssignCleanerModal = false;
        $this->dispatch('closeAssignCleanerModal');
    }

    // #[On('deletedCleaner')]
    // public function handleDeletedCleaner()
    // {
    //     // Refresh the service request details after a cleaner assignment is deleted
    //     $this->render();

    // }

    public function render()
    {
        $this->serviceRequest = ServiceRequest::with('client','serviceRequestPeriods.service', 'assignedMaids', 'serviceCharges')
        ->orderBy('id', 'desc')->findOrFail($this->id);

        return view('livewire.pages.service-request-view', ['serviceRequest' => $this->serviceRequest])->layout('components.dash-board');
    }
}
