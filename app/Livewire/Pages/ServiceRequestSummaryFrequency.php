<?php

namespace App\Livewire\Pages;

use App\Models\ServiceRequest;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\Attributes\On;

class ServiceRequestSummaryFrequency extends Component
{

    public $frequency;
    public $searchByRequestDate;
    public $startDate;
    public $endDate;

   #[On('searchByRequestDateUpdated')]
    public function searchByRequestDateUpdated($value, $startDate, $endDate)
    {
        $this->searchByRequestDate = $value;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }


    public function mount($frequency)
    {
        $this->frequency = $frequency;

    }

    public function render()
    {

        $query = ServiceRequest::query()
                    ->with('serviceRequestPeriods', 'assignedMaids', 'serviceCharge', 'client')
                    ->where('frequency', $this->frequency)
                    ->when($this->searchByRequestDate, function ($query) {
                        $query->whereBetween('service_request_date', [$this->startDate, $this->endDate]);
                    })
                    ->get()
                    ->sortByDesc('id')
                    ;
        return view('livewire.pages.service-request-summary-frequency', ['serviceRequests' => $query])->layout('components.dash-board');
    }
}
