<?php

namespace App\Livewire\Pages;

use App\Models\Client;
use Livewire\Component;

class ClientView extends Component
{
    public $client;

    public function mount($id)
    {
        // Fetch client data based on the provided ID
        $this->client = Client::find($id);
    }

    public function render()
    {
        $query = Client::with('serviceRequests')->findOrFail($this->client->id);
        return view('livewire.pages.client-view', ['client' => $query])->layout('components.dash-board');
    }
}
