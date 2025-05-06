<?php

namespace App\Livewire\Timesheets;

use App\Models\Timesheet;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $timesheets;

    public function mount()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $this->timesheets = Timesheet::with('user')
                ->latest('week_starting')
                ->get();
        } else {
            $this->timesheets = Timesheet::where('user_id', $user->id)
                ->with('user')
                ->latest('week_starting')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.timesheets.index', [
            'timesheets' => $this->timesheets,
        ]);
    }
}