<?php

use App\Livewire\Pages\Cleaners;
use App\Livewire\Pages\CleanerView;
use App\Livewire\Pages\ClientsSummary;
use App\Livewire\Pages\ClientView;
use App\Livewire\Pages\DashBoard;
use App\Livewire\Pages\ScheduleDaily;
use App\Livewire\Pages\ScheduleSummary;
use App\Livewire\Pages\ServiceRequestSummary;
use App\Livewire\Pages\ServiceRequestSummaryFrequency;
use App\Livewire\Pages\ServiceRequestView;
use Illuminate\Support\Facades\Route;

Route::livewire('/',  ServiceRequestSummary::class)->name('home');

Route::livewire('/dashboard', ScheduleSummary::class)->name('dashboard');
Route::livewire('/schedule-summary', ScheduleSummary::class)->name('schedule-summary');
Route::livewire('/scheduleView/daily', ScheduleDaily::class)->name('schedule-daily');
Route::livewire('/service-request-summary', ServiceRequestSummary::class)->name('service-request-summary');
Route::livewire('/service-request-summary/{frequency}', ServiceRequestSummaryFrequency::class)->name('service-request-summary-frequency');
Route::livewire('/service-request/{id}', ServiceRequestView::class)->name('service-request-view');
Route::livewire('/clients', ClientsSummary::class)->name('clients');
Route::livewire('/clients/{id}', ClientView::class)->name('client-view');
Route::livewire('/cleaners', Cleaners::class)->name('cleaners');
Route::livewire('/cleaners/{id}', CleanerView::class)->name('cleaner-view');


Route::livewire('/new-service-request', \App\Livewire\Forms\NewServiceRequest::class)->name('new-service-request');
Route::livewire('/new-service-schedule', \App\Livewire\Forms\NewServiceSchedule::class)->name('new-service-schedule');
Route::livewire('/new-service-charge/{id}', \App\Livewire\Forms\NewServiceCharge::class)->name('new-service-charge');
Route::livewire('/assign-cleaner', \App\Livewire\Forms\AssignCleaner::class)->name('assign-cleaner');

Route::livewire('/new-client', \App\Livewire\Forms\NewClient::class)->name('new-client');
Route::livewire('/new-cleaner', \App\Livewire\Forms\NewMaid::class)->name('new-maid');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::view('dashboard', 'dashboard')->name('dashboard');
// });

require __DIR__.'/settings.php';
