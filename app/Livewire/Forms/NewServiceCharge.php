<?php

namespace App\Livewire\Forms;

use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Livewire\Component;

class NewServiceCharge extends Component
{

    public $service_request_id;
    public $serviceRequest;
    public $services;
    public $service_id;
    public $invoice_date;
    public $material_consumption;
    public $description;
    public $amount;
    public $receipt_no;
    public $payment_method;
    public $paymentMethods = [];


    public function mount(Request $request, $id)
    {
        // You can initialize any properties or perform any setup logic here if needed


        // dd($id);
        $this->paymentMethods = ['Cash', 'Fawran', 'Bank Transfer', 'Other']; // Example payment methods, you can customize this as needed

        // dd($request->all());
//
        if($id) {

          $this->service_request_id= $id;
            // You can use this service request ID to load any relevant data or perform any necessary actions

            $this->serviceRequest = ServiceRequest::with('serviceRequestPeriods', 'serviceCharge', 'client')->findOrFail($this->service_request_id);
            $this->services = Service::all(); // Assuming you have a Services model to fetch available services

            //check the url query has sc parameter for edit mode
            if($request->has('sc')) {
                $serviceChargeId = $request->query('sc');
                $serviceCharge = $this->serviceRequest->serviceCharge()->find($serviceChargeId);
                if($serviceCharge) {
                    $this->service_id = $serviceCharge->service_id;
                    $this->invoice_date = $serviceCharge->invoice_date;
                    $this->material_consumption = $serviceCharge->material_consumption;
                    $this->description = $serviceCharge->description;
                    $this->amount = $serviceCharge->amount;
                    $this->receipt_no = $serviceCharge->receipt_no;
                    $this->payment_method = $serviceCharge->payment_method;
                } else {
                    redirect()->route('service-request-view', ['id' => $this->service_request_id])->with('error', 'Service charge not found for editing.')->send();
                }

         }
    }

    }

    public function saveForm()
    {
        $validated = $this->validate([
            'service_request_id' => 'required|exists:service_requests,id',
            'invoice_date' => 'required|date',
            'material_consumption' => 'boolean',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'receipt_no' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:255',
        ]);


        $serviceCharge = \App\Models\ServiceCharge::updateOrCreate(
            ['service_request_id' => $this->service_request_id],
            $validated
        );

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
