<?php

namespace App\Livewire\Pages;

use App\Models\Maid;
use App\Models\ServiceRequest;
use Livewire\Component;

class Cleaners extends Component
{
    public $maidScheduleSearchDate;

    public function mount()
    {
        $this->maidScheduleSearchDate = \Carbon\Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        $query = Maid::query()
                         ->with('assignments', 'serviceRequestPeriods','assignments.serviceRequestPeriod.serviceRequest', 'assignments.serviceRequestPeriod.serviceRequest.client')
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ;


                            //total Earning using service request table

        $totalEarning = ServiceRequest::sum('earned');


        return view('livewire.pages.cleaners', ['maids' => $query, 'totalEarning' => $totalEarning])->layout('components.dash-board');
    }
}
