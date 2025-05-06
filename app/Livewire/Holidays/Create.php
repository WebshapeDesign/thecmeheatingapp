<?php

namespace App\Livewire\Holidays;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $user_id;
    public $date_requested;
    public $holiday_start_date;
    public $holiday_end_date;
    public $number_of_days;

    public function mount()
    {
        $this->date_requested = Carbon::now()->format('d/m/Y');

        if (Auth::user()->isAdmin()) {
            $this->user_id = null;
        } else {
            $this->user_id = Auth::id();

            if (Auth::user()->holiday_days_remaining <= 0) {
                abort(403, 'You have no remaining holiday days.');
            }
        }
    }

    protected function rules(): array
    {
        $userId = $this->user_id ?? Auth::id();
        $user = User::findOrFail($userId);

        return [
            'user_id' => 'required|exists:users,id',
            'date_requested' => 'required|date_format:d/m/Y',
            'holiday_start_date' => 'required|date|after_or_equal:' . Carbon::createFromFormat('d/m/Y', $this->date_requested)->format('Y-m-d'),
            'holiday_end_date' => 'required|date|after_or_equal:holiday_start_date',
            'number_of_days' => [
                'required',
                'integer',
                'min:1',
                'max:' . $user->holiday_days_remaining
            ],
        ];
    }

    public function store()
    {
        $this->validate();

        $parsedDate = Carbon::createFromFormat('d/m/Y', $this->date_requested)->format('Y-m-d');

        $holiday = Holiday::create([
            'user_id' => $this->user_id,
            'date_requested' => $parsedDate,
            'holiday_start_date' => $this->holiday_start_date,
            'holiday_end_date' => $this->holiday_end_date,
            'number_of_days' => $this->number_of_days,
            'status' => 'requested',
        ]);

        session()->flash('message', 'Holiday request submitted successfully.');

        return redirect()->route('holidays.show', $holiday);
    }

    public function render()
    {
        return view('livewire.holidays.create', [
            'remaining_days' => Auth::user()->holiday_days_remaining,
            'users' => Auth::user()->isAdmin() ? User::all() : [],
        ]);
    }
}
