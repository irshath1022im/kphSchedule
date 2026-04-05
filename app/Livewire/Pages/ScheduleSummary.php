<?php

namespace App\Livewire\Pages;

use App\Models\ServiceRequest;
use App\Models\ServiceRequestPeriod;
use Livewire\Component;

class ScheduleSummary extends Component
{
    public $today;
    public $search_startDate;
    public $search_endDate;



    // public $today;
    // public $monthStart;
    // public $monthEnd;
    // public $leadingBlankDays;
    // public $daysInMonth;
    // public $bookingsByDay;
    // public $dailyHours;
    // public $weeklyServices;
    // public $monthlyServices;
    // public $maxWeekly;

    public function mount()
    {
        $this->today = now();
        $this->search_startDate = $this->today->toDateString();
        $this->search_endDate = $this->today->toDateString();
        $this->monthStart = $this->today->copy()->startOfMonth();
        $this->monthEnd = $this->today->copy()->endOfMonth();
        $this->leadingBlankDays = $this->monthStart->dayOfWeekIso - 1;
        $this->daysInMonth = $this->monthEnd->day;

        $requestPeriods = ServiceRequestPeriod::with('serviceRequest')
            ->whereBetween('start_date', [$this->monthStart, $this->monthEnd])
            ->get();

    // $this->bookingsByDay = [
    //     1 => ['count' => 4, 'hours' => 10],
    //     2 => ['count' => 5, 'hours' => 12],
    //     3 => ['count' => 3, 'hours' => 7],
    //     4 => ['count' => 6, 'hours' => 15],
    //     5 => ['count' => 2, 'hours' => 4],
    //     6 => ['count' => 7, 'hours' => 16],
    //     7 => ['count' => 4, 'hours' => 9],
    //     8 => ['count' => 5, 'hours' => 11],
    //     9 => ['count' => 6, 'hours' => 13],
    //     10 => ['count' => 3, 'hours' => 8],
    //     11 => ['count' => 5, 'hours' => 12],
    //     12 => ['count' => 4, 'hours' => 10],
    //     13 => ['count' => 8, 'hours' => 18],
    //     14 => ['count' => 7, 'hours' => 17],
    //     15 => ['count' => 3, 'hours' => 6],
    //     16 => ['count' => 5, 'hours' => 11],
    //     17 => ['count' => 4, 'hours' => 9],
    //     18 => ['count' => 6, 'hours' => 14],
    //     19 => ['count' => 5, 'hours' => 12],
    //     20 => ['count' => 7, 'hours' => 16],
    //     21 => ['count' => 2, 'hours' => 5],
    //     22 => ['count' => 4, 'hours' => 9],
    //     23 => ['count' => 6, 'hours' => 13],
    //     24 => ['count' => 8, 'hours' => 19],
    //     25 => ['count' => 7, 'hours' => 16],
    //     26 => ['count' => 4, 'hours' => 8],
    //     27 => ['count' => 5, 'hours' => 11],
    //     28 => ['count' => 6, 'hours' => 14],
    //     29 => ['count' => 3, 'hours' => 7],
    //     30 => ['count' => 5, 'hours' => 12],
    //     31 => ['count' => 4, 'hours' => 9],
    // ];

    // $this->dailyHours = [
    //     ['time' => '08:00', 'client' => 'Maria Santos', 'service' => 'Deep Cleaning', 'duration' => '2h'],
    //     ['time' => '10:30', 'client' => 'John Cruz', 'service' => 'Regular Cleaning', 'duration' => '1.5h'],
    //     ['time' => '13:00', 'client' => 'Liza Gomez', 'service' => 'Move-out Cleaning', 'duration' => '3h'],
    //     ['time' => '16:30', 'client' => 'Carlos dela Cruz', 'service' => 'Office Cleaning', 'duration' => '2h'],
    // ];

    // $this->weeklyServices = [
    //     ['day' => 'Mon', 'services' => 12],
    //     ['day' => 'Tue', 'services' => 15],
    //     ['day' => 'Wed', 'services' => 10],
    //     ['day' => 'Thu', 'services' => 16],
    //     ['day' => 'Fri', 'services' => 14],
    //     ['day' => 'Sat', 'services' => 9],
    //     ['day' => 'Sun', 'services' => 6],
    // ];

    // $this->monthlyServices = [
    //     ['label' => 'Regular Cleaning', 'count' => 82, 'color' => 'bg-blue-500'],
    //     ['label' => 'Deep Cleaning', 'count' => 46, 'color' => 'bg-emerald-500'],
    //     ['label' => 'Move-out Cleaning', 'count' => 28, 'color' => 'bg-amber-500'],
    //     ['label' => 'Office Cleaning', 'count' => 34, 'color' => 'bg-violet-500'],
    // ];

    // $this->maxWeekly = collect($this->weeklyServices)->max('services');

    }


    public function setToday(): void
    {
        $this->search_startDate = now()->toDateString();
        $this->search_endDate   = now()->toDateString();
    }

    public function setYesterday(): void
    {
        $this->search_startDate = now()->subDay()->toDateString();
        $this->search_endDate   = now()->subDay()->toDateString();
    }

    public function setTomorrow(): void
    {
        $this->search_startDate = now()->addDay()->toDateString();
        $this->search_endDate   = now()->addDay()->toDateString();
    }

    public function setThisWeek(): void
    {
        $this->search_startDate = now()->startOfWeek()->toDateString();
        $this->search_endDate   = now()->endOfWeek()->toDateString();
    }

    public function setThisMonth(): void
    {
        $this->search_startDate = now()->startOfMonth()->toDateString();
        $this->search_endDate   = now()->endOfMonth()->toDateString();
    }

    public function clearFilters(): void
    {
        $this->search_startDate = null;
        $this->search_endDate   = null;
    }

    public function render()
    {


        $query = ServiceRequestPeriod::with('serviceRequest.client', 'service', 'maidAssignments.maid')
            ->when($this->search_startDate && $this->search_endDate, function ($q) {
                $q->whereBetween('start_date', [$this->search_startDate, $this->search_endDate]);
            })
            ->get()
            ->groupBy('start_date');

        return view('livewire.pages.schedule-summary', ['schedule' => $query])->layout('components.dash-board');
    }
}
