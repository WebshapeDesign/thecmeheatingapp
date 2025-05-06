<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class MileageLogs extends Component
{
    public Vehicle $vehicle;

    public function mount(Vehicle $vehicle)
    {
        if (Gate::denies('view', $vehicle)) {
            abort(403);
        }

        $this->vehicle = $vehicle;
    }

    public function render()
    {
        $logs = $this->vehicle->mileageLogs()
            ->with('user')
            ->orderByDesc('week_starting')
            ->get();

        return view('livewire.vehicles.mileage-logs', [
            'logs' => $logs,
            'vehicle' => $this->vehicle,
        ]);
    }
}
