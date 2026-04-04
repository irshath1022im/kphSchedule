<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class NewClient extends Component
{

    public $name;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $location;
    public $locations = [];

    public function mount()
    {
        $this->locations = ['Doha', 'Al Saad', 'West Bay', 'Lusail', 'Najma', 'Al Waaba', 'Bin Mahmood', 'Al Hilal', 'West Bay', 'City Center'];   // Initialize any default values if needed
    }


    public function submit()
    {
        // Validate the input data
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
        ]);

        // Create a new client record in the database
        \App\Models\Client::create($validatedData);

        // Optionally, you can reset the form fields after submission


        // You can also emit an event or redirect to another page after successful submission
        redirect()->route('clients')->with('success', 'Client added successfully!');
    }


    public function render()
    {
        return view('livewire.forms.new-client')->layout('components.dash-board');
    }
}
