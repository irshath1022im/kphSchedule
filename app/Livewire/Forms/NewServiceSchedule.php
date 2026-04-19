<?php

namespace App\Livewire\Forms;

use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestPeriod;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\On;
use Livewire\Component;

class NewServiceSchedule extends Component
{

    public $request_id; //int
    public $service_id; //int
    public $start_date; //date
    public $end_date;
    public $day_of_week; //string
    public $start_time; //time
    public $end_time;
    public $duration_hours; //int
    public $status; //string

    public $statusList = [];
    public $services = [];
    public $service_request_date;
    public $frequecy;
    public $monthlyServiceDays = [];
    public $editPeriodId; //to track the period being edited, if any


    #[On('editServiceRequestPeriod')]
    public function loadServiceRequestPeriod($period)
    {
        $this->editPeriodId = $period['id'];
       $editPeriod = ServiceRequestPeriod::findOrFail($period['id']);
        $this->request_id = $editPeriod->request_id;
        $this->service_id = $editPeriod->service_id;
        $this->start_date = Carbon::parse($editPeriod->start_date)->toDateString();
        $this->end_date = Carbon::parse($editPeriod->end_date)->toDateString();
        $this->day_of_week = Carbon::parse($editPeriod->day_of_week)->format('l');
        $this->start_time = Carbon::parse($editPeriod->start_time)->format('H:i');
        $this->end_time = Carbon::parse($editPeriod->end_time)->format('H:i');
        $this->duration_hours = intval($editPeriod->duration_hours);
        $this->status = $editPeriod->status;
    }

    #[On('closeScheduleModal')]
    public function closeModal()
    {
        $this->reset(['service_id', 'start_date', 'end_date', 'day_of_week', 'start_time', 'end_time', 'duration_hours', 'status']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->editPeriodId = null;
    }


    public function mount($id)
    {
        $this->request_id = $id;

        $serviceRequest = ServiceRequest::findOrFail($id);
        $this->request_id = $serviceRequest->id;
        $this->service_request_date = Carbon::parse($serviceRequest->service_request_date)->toDateString();
        $this->frequecy = $serviceRequest->frequency;

        $this->statusList = [
            'Scheduled',
            'In Progress',
            'Completed',
            'Cancelled',
            'Day-off',
            'Postponed',
        ];

        $this->services = Service::all(); // Fetch all services to populate the dropdown in the form

    }

    public function updated($start_date)
    {

        $this->resetErrorBag('start_date'); // Clear validation errors for start_date when it changes

        if ($this->frequecy === 'one-time' && $this->start_date) {

            $date = \Carbon\Carbon::parse($this->start_date);
            $this->end_date = $date->copy()->toDateString();

            $this->validateOnly('start_date', [
                'start_date' => 'required|date|after_or_equal:' . $this->service_request_date,
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

        }

        if (($this->frequecy === 'monthly-leave-in' || $this->frequecy === 'monthly-leave-out') && $this->start_date) {

            $date = \Carbon\Carbon::parse($this->start_date);
            $this->end_date = $date->addMonth()->toDateString();

            $this->validateOnly('start_date', [
                'start_date' => 'required|date|after_or_equal:' . $this->service_request_date,
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

        }
    }

    public function updatedDurationHours()
    {
        $this->resetErrorBag('duration_hours'); // Clear validation errors for duration_hours when it changes

        if ($this->duration_hours && $this->start_time) {

            $this->validateOnly('duration_hours', [
                'duration_hours' => 'required',
            ]);

            $this->end_time = \Carbon\Carbon::parse($this->start_time)->addHours(intval($this->duration_hours))->format('H:i');
        }
    }



    public function save()
    {
        $this->validate([
            'request_id' => 'required|integer',
            'service_id' => 'required|integer',
            'start_date' => 'required|date|after_or_equal:' . $this->service_request_date,
            'end_date' => 'required|date|after_or_equal:start_date',
            'day_of_week' => 'nullable|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration_hours' => 'required',
            'status' => 'required|string',
        ]);


        $startTimeValidation = ServiceRequestPeriod::where('request_id', $this->request_id)
            ->where('start_date', $this->start_date)
            ->where('start_time', $this->start_time)
            ->exists();

        if ($startTimeValidation) {
            $this->addError('start_time', 'The selected start time is already scheduled for this request.');
            return;
        }

        if($this->end_time <= $this->start_time){
            $this->addError('end_time', 'End time must be after start time.');
            return;

        }


        //generate monthly service days between start date and end date

        $startDate = \Carbon\Carbon::parse($this->start_date);
        $endDate = \Carbon\Carbon::parse($this->end_date);

           $period = CarbonPeriod::create($startDate, $endDate);
           $dates = $period->toArray();


            foreach ($dates as $date) {
                $this->monthlyServiceDays[] = $date->toDateString();
            }

            foreach($this->monthlyServiceDays as $serviceDay){
                ServiceRequestPeriod::create([
                    'request_id' => $this->request_id,
                    'service_id' => $this->service_id,
                    'start_date' => $serviceDay,
                    'day_of_week' => Carbon::parse($serviceDay)->format('N'), //number between 1 (for Monday) and 7 (for Sunday)
                    'start_time' => $this->start_time,
                    'end_date' => $serviceDay,
                    'end_time' => $this->end_time,
                    'duration_hours' => $this->duration_hours,
                    'status' => $this->status,
                ]);


        }


        session()->flash('message', 'Service schedule created successfully.');

        return redirect()->route('service-request-view', ['id' => $this->request_id]);
    }

    public function scheduleUpdate()
    {
        $this->validate([
            'request_id' => 'required|integer',
            'service_id' => 'required|integer',
            'start_date' => 'required|date|after_or_equal:' . $this->service_request_date,
            'end_date' => 'required|date|after_or_equal:start_date',
            'day_of_week' => 'nullable|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration_hours' => 'required',
            'status' => 'required|string',
        ]);

        $period = ServiceRequestPeriod::findOrFail($this->editPeriodId);
        $period->update([
            'request_id' => $this->request_id,
            'service_id' => $this->service_id,
            'start_date' => $this->start_date,
            'day_of_week' => Carbon::parse($this->day_of_week)->format('N'), //number between 1 (for Monday) and 7 (for Sunday)
            'start_time' => $this->start_time,
            'end_date' => $this->end_date,
            'end_time' => $this->end_time,
            'duration_hours' => $this->duration_hours,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Service schedule updated successfully.');

        return redirect()->route('service-request-view', ['id' => $this->request_id]);
    }

    public function render()
    {
        return view('livewire.forms.new-service-schedule')->layout(
            'components.dash-board'
        );
    }
}
