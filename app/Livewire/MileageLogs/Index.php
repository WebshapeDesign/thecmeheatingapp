<?php

namespace App\Livewire\MileageLogs;

use App\Models\MileageLog;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $logs;

    public function mount()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $this->logs = MileageLog::with('vehicle', 'user')
                ->latest('week_starting')
                ->get();
        } elseif ($user->vehicle) {
            $this->logs = MileageLog::where('vehicle_id', $user->vehicle->id)
                ->with('vehicle', 'user')
                ->latest('week_starting')
                ->get();
        } else {
            $this->logs = collect();
        }
    }

    public function render()
    {
        return view('livewire.mileagelogs.index', [
            'mileageLogs' => $this->logs,
        ]);
    }
}
