<?php

namespace App\Livewire\Holidays;

use App\Models\Holiday;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $holidays;

    public function mount()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $this->holidays = Holiday::with('user')
                ->latest('created_at')
                ->get();
        } else {
            $this->holidays = Holiday::where('user_id', $user->id)
                ->latest('created_at')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.holidays.index');
    }
}
