<?php

namespace App\Livewire\Forms;

use Illuminate\Http\Request;
use Livewire\Component;

class NewClient extends Component
{

    public $clientId;
    public $name;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $location;
    public $locations = [];

    public function mount(Request $request)
    {
        $this->locations = ['Doha', 'Al Saad', 'West Bay', 'Lusail', 'Najma', 'Al Waaba', 'Bin Mahmood', 'Al Hilal', 'West Bay', 'City Center', 'Pearl', 'Airport'];   // Initialize any default values if needed

        if ($request->has('client_id')) {
            $client = \App\Models\Client::find($request->query('client_id'));

            if ($client) {
                $this->clientId = $client->id;
                $this->name = $client->name;
                $this->email = $client->email;
                $this->phone = $client->phone;
                $this->address = $client->address;
                $this->city = $client->city;
                $this->location = $client->location;
            }
        }


    }


    public function submit()
    {
        // Validate the input data
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
        ]);

        // Create a new client record in the database
        \App\Models\Client::updateOrCreate(['id' => $this->clientId], $validatedData);

        // Optionally, you can reset the form fields after submission


        // You can also emit an event or redirect to another page after successful submission
        redirect()->route('clients')->with('success', 'Client added successfully!');
    }


    public function render()
    {
        return view('livewire.forms.new-client')->layout('components.dash-board');
    }
}
