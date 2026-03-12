<?php

use App\Livewire\Pages\DashBoard;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::livewire('/dashboard', DashBoard::class)->name('dashboard');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::view('dashboard', 'dashboard')->name('dashboard');
// });

require __DIR__.'/settings.php';
