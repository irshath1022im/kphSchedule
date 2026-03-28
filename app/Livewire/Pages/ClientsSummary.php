<?php

namespace App\Livewire\Pages;

use App\Models\Client;
use App\Models\Maid;
use App\Models\ServiceRequest;
use Livewire\Component;

class ClientsSummary extends Component
{
    public function render()
    {
        $query = Client::query()->with('serviceRequests');
        // $serviceHistory = ServiceRequest::with(['client'])->orderBy('service_request_date', 'desc')->get();
        $maids = Maid::query()->get();
        return view('livewire.pages.clients-summary', [
            'clients' => $query->get(),
            'maids' => $maids
            ])->layout('components.dash-board');
    }
}
