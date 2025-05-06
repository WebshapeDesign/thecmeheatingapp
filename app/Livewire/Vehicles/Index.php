<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;

class Index extends Component
{
    public $vehicles;

    public function mount()
    {
        // Eager load user for display in the table
        $this->vehicles = Vehicle::with('user')->orderBy('registration_number')->get();
    }

    public function render()
    {
        return view('livewire.vehicles.index');
    }
}
