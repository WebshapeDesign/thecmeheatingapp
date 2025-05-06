<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;

class Show extends Component
{
    public Vehicle $vehicle;

    public function mount(Vehicle $vehicle)
    {
        // Eager-load the related user for display
        $this->vehicle = $vehicle->load('user');
    }

    public function render()
    {
        return view('livewire.vehicles.show');
    }
}
