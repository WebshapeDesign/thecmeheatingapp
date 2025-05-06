<?php

namespace App\Livewire\VanLogs;

use Livewire\Component;
use App\Models\VanLog;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $vanlogs;

    public function mount()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admin sees all logs
            $this->vanlogs = VanLog::with(['vehicle', 'user'])
                ->orderBy('week_starting', 'desc')
                ->get();
        } else {
            // Standard users see only their own logs
            $this->vanlogs = VanLog::with('vehicle')
                ->where('user_id', $user->id)
                ->orderBy('week_starting', 'desc')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.vanlogs.index');
    }
}
