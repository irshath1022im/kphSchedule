<?php

namespace App\Livewire\Forms;

use App\Models\ServiceRequest;
use Livewire\Component;

class NewServiceCharge extends Component
{

    public $service_request_id;
    public $serviceRequest;
    public $services;
    public $service_id;
    public $service_date;
    public $end_date;
    public $material_consumption;
    public $description;
    public $worked_hours;
    public $assigned_maids;
    public $amount;


    public function mount()
    {
        // You can initialize any properties or perform any setup logic here if needed

        if(request()->has('sr')) {
          $this->service_request_id= request()->get('sr');
            // You can use this service request ID to load any relevant data or perform any necessary actions

            $this->serviceRequest = ServiceRequest::findOrFail($this->service_request_id);
            $this->services = $this->serviceRequest->services;



        }else{
            return redirect()->route('service-request-summary'); // Redirect to service request summary if no service request ID is provided
        }

    }

    public function saveForm()
    {
        $validated = $this->validate([
            'service_request_id' => 'required|exists:service_requests,id',
            'service_id' => 'required|exists:services,id',
            'service_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:service_date',
            'material_consumption' => 'boolean',
            'description' => 'nullable|string',
            'worked_hours' => 'required|integer|min:0',
            'assigned_maids' => 'required|integer|min:0',
            'amount' => 'required|numeric|min:0',
        ]);


        $serviceCharge = \App\Models\ServiceCharge::create($validated);

        if($serviceCharge) {
            // You can perform any additional actions after successfully saving the service charge, such as redirecting or showing a success message
            session()->flash('success', 'Service charge added successfully!');
            return redirect()->route('service-request-view', ['id' => $this->service_request_id]);
        } else {
            session()->flash('error', 'Failed to add service charge. Please try again.');
        }

    }

    public function render()
    {
        return view('livewire.forms.new-service-charge')->layout('components.dash-board');
    }
}
