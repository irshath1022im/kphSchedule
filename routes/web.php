<?php

use App\Livewire\Pages\Cleaners;
use App\Livewire\Pages\DashBoard;
use App\Livewire\Pages\ClientsSummary;
use App\Livewire\Pages\ScheduleDaily;
use App\Livewire\Pages\ScheduleSummary;
use App\Livewire\Pages\ServiceRequestSummary;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::livewire('/dashboard', DashBoard::class)->name('dashboard');
Route::livewire('/schedule-summary', ScheduleSummary::class)->name('schedule-summary');
Route::livewire('/scheduleView/daily', ScheduleDaily::class)->name('schedule-daily');
Route::livewire('/service-request-summary', ServiceRequestSummary::class)->name('service-request-summary');
Route::livewire('/clients', ClientsSummary::class)->name('clients');
Route::livewire('/cleaners', Cleaners::class)->name('cleaners');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::view('dashboard', 'dashboard')->name('dashboard');
// });

require __DIR__.'/settings.php';
