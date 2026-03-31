<?php

namespace App\Livewire\Forms;

use App\Models\MaidAssignment;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestPeriod;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class AssignCleaner extends Component
{

    public $id;
    public $service_request_id;
    public $numberOfSchedules; //used determind it is monthly contract or not
    public $maids;
    public $service_request_period_id;
    public $notes;
    public $selectedCleaner = [];
    public $maid_id;


    #[On('assignCleaner')]
    public function handleAssignCleaner($id)
    {

        if(in_array('service_request_id', array_keys($id))){
            $this->service_request_id = $id['service_request_id'];
        }elseif(in_array('period_id', array_keys($id))){
            $this->service_request_period_id = $id['period_id'];
        }

    }

    #[On('closeAssignCleanerModal')]
    public function handleCloseAssignCleanerModal()
    {
        $this->reset(['service_request_period_id', 'notes', 'maid_id']);
    }

   

    public function deleteCleaner($lineId)
    {
       MaidAssignment::findOrFail($lineId)->delete();
       
       redirect()->route('service-request-view', ['id' => $this->service_request_id]);
   
    }

    public function mount()
    {
        // $this->service_request_id = $service_request_id;
        // $this->numberOfSchedules = ServiceRequest::findOrFail($service_request_id)->serviceRequestPeriods()->count();
        $this->maids = \App\Models\Maid::get();
      

    }

    public function removeAssignment()
    {
       
         MaidAssignment::whereIn('service_request_period_id', ServiceRequestPeriod::where('request_id', $this->service_request_id)->pluck('id')->toArray())->delete();

        redirect()->route('service-request-view', ['id' => $this->service_request_id])->with('message', 'Cleaner assignment removed successfully!');
    }

    public function updated($selectedCleaner)
    {
        if($this->service_request_id != null || $this->service_request_id != ''){
              $serviceRequestPeriodsId = ServiceRequest::findOrFail($this->service_request_id)->serviceRequestPeriods()->pluck('id')->toArray();

            foreach($serviceRequestPeriodsId as $periodId){
                MaidAssignment::create([
                    'maid_id' => $this->maid_id,
                    'service_request_period_id' => $periodId,
                    'notes' => $this->notes,
                    'date' => Carbon::now()->toDateString(),
                ]);

                } 

                 redirect()->route('service-request-view', ['id' => $this->service_request_id])->with('message', 'Cleaner assigned successfully!');
            
            
            }elseif($this->service_request_period_id != null || $this->service_request_period_id != ''){
                MaidAssignment::create([
                    'maid_id' => $this->maid_id,
                    'service_request_period_id' => $this->service_request_period_id,
                    'notes' => $this->notes,
                    'date' => Carbon::now()->toDateString(),
                ]);

                //refresh the selected cleaner list after assignment
                $this->selectedCleaner = MaidAssignment::with('maid')->where('service_request_period_id', $this->service_request_period_id)->get(); 
                
                    

            }else{
                $this->addError('maid_id', 'The selected period is invalid for this service request.');
            }

            $this->dispatch('closeAssignCleanerModal');



        // if($this->numberOfSchedules > 1){
        //     //get the service request period id detials from serviceRequest_periods using servie_request

        //     $serviceRequestPeriodsId = ServiceRequest::findOrFail($this->service_request_id)->serviceRequestPeriods()->pluck('id')->toArray();

        //     foreach($serviceRequestPeriodsId as $periodId){
        //         MaidAssignment::create([
        //             'maid_id' => $this->maid_id,
        //             'service_request_period_id' => $periodId,
        //             'notes' => $this->notes,
        //             'date' => Carbon::now()->toDateString(),
        //         ]);
        //     }
        // }elseif($this->numberOfSchedules == 1){
        //        MaidAssignment::create([
        //             'maid_id' => $this->maid_id,
        //             'service_request_period_id' => $this->service_request_period_id,
        //             'notes' => $this->notes,
        //             'date' => Carbon::now()->toDateString(),
        //         ]);
        // }
        // else{
        //     $this->addError('maid_id', 'The selected period is invalid for this service request.');
        // }



    }


    public function render()
        {
            $this->selectedCleaner = MaidAssignment::with('maid')->where('service_request_period_id', $this->service_request_period_id)->get();
            return view('livewire.forms.assign-cleaner', ['selectedCleaner' => $this->selectedCleaner]);
        }
}
