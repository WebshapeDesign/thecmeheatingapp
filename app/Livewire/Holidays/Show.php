<?php

namespace App\Livewire\Holidays;

use App\Models\Holiday;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    public Holiday $holiday;

    public function mount(Holiday $holiday)
    {
        $user = Auth::user();

        if (! $user->isAdmin() && $holiday->user_id !== $user->id) {
            abort(403, 'You do not have permission to view this holiday request.');
        }

        $this->holiday = $holiday;
    }

    public function approveHoliday()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($this->holiday->status !== 'requested') {
            session()->flash('error', 'Only requested holidays can be approved.');
            return;
        }

        $user = $this->holiday->user;

        if ($user->holiday_days_remaining < $this->holiday->number_of_days) {
            session()->flash('error', 'User does not have enough remaining holiday days.');
            return;
        }

        $this->holiday->update([
            'status' => 'approved'
        ]);

        $user->decrement('holiday_days_remaining', $this->holiday->number_of_days);

        session()->flash('message', 'Holiday request approved successfully.');
    }

    public function render()
    {
        return view('livewire.holidays.show', [
            'holiday' => $this->holiday,
        ]);
    }
}
