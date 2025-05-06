<?php

namespace App\Livewire\Vehicles;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\VanLog;

class VanLogs extends Component
{
    public Vehicle $vehicle;
    public $logs;

    public function mount(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;

        // Eager load logs, latest first
        $this->logs = $vehicle->vanLogs()->latest('week_starting')->get();
    }

    public function render()
    {
        return view('livewire.vehicles.van-logs', [
            'vehicle' => $this->vehicle,
            'logs' => $this->logs,
        ]);
    }
}
