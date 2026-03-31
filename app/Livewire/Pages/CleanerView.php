<?php

namespace App\Livewire\Pages;

use Carbon\Carbon;
use Livewire\Component;

class CleanerView extends Component
{

    public $cleanerId;
    public $maidScheduleSearchDate;
    public $maidStatus;


    public function mount($id)
    {
        $this->cleanerId = $id;
        // $this->maidScheduleSearchDate = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        $maid = \App\Models\Maid::query()
                ->with([
                    'assignments' => function ($query) {
                        $query->with([
                            'serviceRequestPeriod.serviceRequest.client',
                            'serviceRequestPeriod.service',
                        ])->when($this->maidScheduleSearchDate, function ($assignmentQuery) {
                            $assignmentQuery->whereHas('serviceRequestPeriod', function ($periodQuery) {
                                $periodQuery->whereDate('start_date', $this->maidScheduleSearchDate);
                            });
                        });
                    },
                ])
                ->find($this->cleanerId);

            // $totalHours = $maid->assignments?->pluck('serviceRequestPeriod')?->sum(function ($period) {
            //     return Carbon::parse($period->end_date)->diffInHours(Carbon::parse($period->start_date));
            // }) ?? 0;




        return view('livewire.pages.cleaner-view',
            ['maid' => $maid,
            // 'totalHours' => $totalHours,
            ])->layout('components.dash-board');
    }
}
