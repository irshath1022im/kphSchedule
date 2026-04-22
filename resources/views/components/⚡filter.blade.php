<?php

use Livewire\Component;
use Carbon\Carbon;

new class extends Component
{
    //


    public $frequency;
    public $searchByRequestDate;
    public $startDate;
    public $endDate;


    public function getAllReport()
    {
        $this->searchByRequestDate = false;
        $this->startDate = null;
        $this->endDate = null;
        $this->dispatch('searchByRequestDateUpdated', false, $this->startDate, $this->endDate);

    }

    public function getCurrentMonthReport()
    {
        $this->searchByRequestDate = true;
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->endOfMonth()->toDateString();
        $this->dispatch('searchByRequestDateUpdated', true, $this->startDate, $this->endDate);
    }

    public function getLastMonthReport()
    {   $this->searchByRequestDate = true;
        $this->startDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $this->dispatch('searchByRequestDateUpdated', true, $this->startDate, $this->endDate);
    }

    public function getUpcomingMonthReport()
    {
        $this->searchByRequestDate = true;
        $this->startDate = Carbon::now()->addMonth()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->addMonth()->endOfMonth()->toDateString();
        $this->dispatch('searchByRequestDateUpdated', true, $this->startDate, $this->endDate);
    }

    public function getLast7DaysReport()
    {
        $this->searchByRequestDate = true;

        $this->startDate = Carbon::now()->subDays(7)->toDateString();
        $this->endDate = Carbon::now()->toDateString();
        $this->dispatch('searchByRequestDateUpdated', true, $this->startDate, $this->endDate);
    }

    public function getNext7DaysReport()
    {
        $this->searchByRequestDate = true;
        $this->startDate = Carbon::now()->toDateString();
        $this->endDate = Carbon::now()->addDays(7)->toDateString();
        $this->dispatch('searchByRequestDateUpdated', true, $this->startDate, $this->endDate);
    }
};
?>

<div>
     <div class="rounded-2xl border border-sky-200/80 bg-white/85 p-5 shadow-sm">
        <p class="mb-4 text-sm font-semibold text-sky-950">Filter by Request Date</p>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Quick filter buttons -->
            <div class="space-y-2">
                <p class="text-xs font-medium text-sky-700">Quick Filters</p>
                <div class="flex flex-wrap items-center gap-2">
                    <button class="rounded-full border border-sky-200/70 bg-sky-50/80 px-3 py-1.5 text-xs font-medium text-sky-800 transition hover:bg-sky-100" wire:click="getAllReport">All</button>
                    <button class="rounded-full border border-sky-200/70 bg-sky-50/80 px-3 py-1.5 text-xs font-medium text-sky-800 transition hover:bg-sky-100" wire:click="getCurrentMonthReport">Current Month</button>
                      <button class="rounded-full border border-sky-200/70 bg-sky-50/80 px-3 py-1.5 text-xs font-medium text-sky-800 transition hover:bg-sky-100" wire:click="getLastMonthReport">Last Month</button>
                    <button class="rounded-full border border-sky-200/70 bg-sky-50/80 px-3 py-1.5 text-xs font-medium text-sky-800 transition hover:bg-sky-100" wire:click="getUpcomingMonthReport">Upcoming Month</button>
                    <button class="rounded-full border border-sky-200/70 bg-sky-50/80 px-3 py-1.5 text-xs font-medium text-sky-800 transition hover:bg-sky-100" wire:click="getLast7DaysReport">Last 7 Days</button>
                    <button class="rounded-full border border-sky-200/70 bg-sky-50/80 px-3 py-1.5 text-xs font-medium text-sky-800 transition hover:bg-sky-100" wire:click="getNext7DaysReport">Next 7 Days</button>
                </div>
            </div>

            <!-- Custom date range -->
            <div class="space-y-2">
                <p class="text-xs font-medium text-sky-700">Custom Range</p>
                <div class="flex items-center gap-2">
                    <input type="date" wire:model.live="startDate" class="rounded-lg border border-sky-200/70 bg-white/80 px-3 py-1.5 text-sm text-sky-800 shadow-sm">
                    <span class="text-sm font-medium text-sky-700">to</span>
                    <input type="date" wire:model.live="endDate" class="rounded-lg border border-sky-200/70 bg-white/80 px-3 py-1.5 text-sm text-sky-800 shadow-sm">
                </div>
            </div>
        </div>
     </div>
</div>
