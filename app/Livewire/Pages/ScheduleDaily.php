<?php

namespace App\Livewire\Pages;

use App\Models\ServiceRequestPeriod;
use Livewire\Component;

class ScheduleDaily extends Component
{

    public $selectedDate;

    public $bookings;
    public $hours;
    public $hourSummary;
    public $totalBookings;
    public $totalBookedHours;
    public $maxConcurrent;
    public $hoursWithTwo;
    public $hoursWithThreeOrMore;
    public $activeNow;

    public function mount()
    {
        $this->selectedDate = now();

        $this->bookings = ServiceRequestPeriod::with(['serviceRequest.client', 'service'])
            ->withWhereHas('serviceRequest', function ($query) {
                $query->whereDate('service_request_date', $this->selectedDate);
            })
            ->get();

}

    public function render()
    {
        return view('livewire.pages.schedule-daily')->layout('components.dash-board');
    }
}
