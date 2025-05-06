<?php

namespace App\Livewire\Holidays;

use App\Models\Holiday;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public Holiday $holiday;

    public $holiday_start_date;
    public $holiday_end_date;
    public $number_of_days;

    public function mount(Holiday $holiday)
    {
        if (!Auth::user()->isAdmin() && $holiday->user_id !== Auth::id()) {
            abort(403);
        }

        if (!Auth::user()->isAdmin() && $holiday->status === 'approved') {
            abort(403, 'You cannot edit an approved holiday request.');
        }

        $this->holiday = $holiday;
        $this->holiday_start_date = optional($holiday->holiday_start_date)->format('Y-m-d');
        $this->holiday_end_date = optional($holiday->holiday_end_date)->format('Y-m-d');
        $this->number_of_days = $holiday->number_of_days;
    }

    protected function rules(): array
    {
        return [
            'holiday_start_date' => 'required|date',
            'holiday_end_date' => 'required|date|after_or_equal:holiday_start_date',
            'number_of_days' => 'required|integer|min:1|max:' . $this->holiday->user->holiday_days_remaining,
        ];
    }

    public function update()
    {
        $this->validate();

        if (!Auth::user()->isAdmin() && $this->holiday->status === 'approved') {
            abort(403, 'Cannot update an approved holiday request.');
        }

        $this->holiday->update([
            'holiday_start_date' => $this->holiday_start_date,
            'holiday_end_date' => $this->holiday_end_date,
            'number_of_days' => $this->number_of_days,
        ]);

        session()->flash('message', 'Holiday request updated successfully.');

        return redirect()->route('holidays.show', $this->holiday);
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
        return view('livewire.holidays.edit', [
            'user_name' => $this->holiday->user->name,
            'holiday_days_remaining' => $this->holiday->user->holiday_days_remaining,
        ]);
    }
}
