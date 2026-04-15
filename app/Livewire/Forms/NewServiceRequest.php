<?php

namespace App\Livewire\Forms;

use Illuminate\Http\Request;
use Livewire\Component;

class NewServiceRequest extends Component
{

    public $service_request_date,
            $client_id,
            $frequency,
            $notes,
            $status;

    public $frequencies;
    public $statuses = ['pending', 'completed', 'cancelled'];
    public $clients;
    public $request_id;


    public function mount(Request $request)
    {
        $this->frequencies = ['one-time', 'daily', 'weekly','monthly-leave-in', 'monthly-leave-out'];
        $this->clients = \App\Models\Client::all();

        $this->request_id = $request->query('id');
        if ($this->request_id) {
            $serviceRequest = \App\Models\ServiceRequest::find($this->request_id);
            if ($serviceRequest) {
                $this->service_request_date = $serviceRequest->service_request_date;
                $this->client_id = $serviceRequest->client_id;
                $this->frequency = $serviceRequest->frequency;
                $this->notes = $serviceRequest->notes;
                $this->status = $serviceRequest->status;
            }
        }
    }

    public function newRequest()
    {
        $this->validate([
                'service_request_date' => 'required',
                'client_id' => 'required',
                'frequency' => 'required',
                'notes' => 'nullable',
                'status' => 'nullable'
        ]);

        \App\Models\ServiceRequest::updateOrCreate(
            ['id' => $this->request_id],
            [
                'service_request_date' => $this->service_request_date,
                'client_id' => $this->client_id,
                'frequency' => $this->frequency,
                'notes' => $this->notes,
                'status' => $this->status
            ]
        );

        // session()->flash('message', $this->request_id ? 'Service Request updated successfully!' : 'Service Request created successfully!');
        // return redirect()->route('service-request-summary');

        if($this->request_id) {
            redirect()->route('service-request-view',['id' => $this->request_id])->with('message', 'Service Request updated successfully!');
        } else {
            redirect()->route('service-request-summary')->with('message', 'Service Request created successfully!');
        }

    }

    public function render()
    {
        return view('livewire.forms.new-service-request')->layout('components.dash-board');
    }
}
