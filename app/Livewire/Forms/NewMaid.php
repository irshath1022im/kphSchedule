<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class NewMaid extends Component
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
        //generate country list for location
        $this->locations = ['India', 'Ethiopia', 'Philippines'];   // Initialize any default values if needed
    }

    public function submit()
    {
        // Validate the input data
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:maids,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
        ]);

        // Create a new maid record in the database
        \App\Models\Maid::create($validatedData);

        // Optionally, you can reset the form fields after submission
        $this->reset(['name', 'email', 'phone', 'address', 'city', 'location']);

    }


    public function render()
    {
        return view('livewire.forms.new-maid')->layout('components.dash-board');
    }
}
