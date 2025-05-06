<?php

namespace App\Livewire\Timesheets;

use App\Models\Timesheet;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $week_starting;
    public $days = [];
    public $expenses_materials = 0;
    public $expenses_other = 0;
    public $expenses_total = 0;
    public $status = 'draft';

    public function mount()
    {
        $this->week_starting = Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        $startOfWeek = Carbon::parse($this->week_starting);
        $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        foreach ($dayNames as $index => $day) {
            $this->days[$index] = [
                'label' => $day,
                'date' => $startOfWeek->copy()->addDays($index)->format('Y-m-d'),
                'entries' => [], // No entries until user adds
                'total_hours' => 0,
                'travel_hours' => 0,
            ];
        }
    }

    public function addEntry($index)
    {
        if (!isset($this->days[$index]['entries']) || !is_array($this->days[$index]['entries'])) {
            $this->days[$index]['entries'] = [];
        }

        $this->days[$index]['entries'][] = [
            'time' => '',
            'description' => '',
        ];
    }

    public function removeEntry($index, $entryIndex)
    {
        if (isset($this->days[$index]['entries'][$entryIndex])) {
            unset($this->days[$index]['entries'][$entryIndex]);
            $this->days[$index]['entries'] = array_values($this->days[$index]['entries']);
        }
    }

    public function updated($property)
    {
        if (in_array($property, ['expenses_materials', 'expenses_other'])) {
            $this->expenses_total = ($this->expenses_materials ?? 0) + ($this->expenses_other ?? 0);
        }
    }

    protected function rules(): array
    {
        return [
            'week_starting' => 'required|date',
            'days' => 'required|array',
            'days.*.label' => 'required|string',
            'days.*.date' => 'required|date',
            'days.*.entries' => 'required|array|min:1',
            'days.*.entries.*.time' => 'required|string',
            'days.*.entries.*.description' => 'required|string',
            'days.*.total_hours' => 'required|numeric|min:0',
            'days.*.travel_hours' => 'required|numeric|min:0',
            'expenses_materials' => 'nullable|numeric|min:0',
            'expenses_other' => 'nullable|numeric|min:0',
            'expenses_total' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,submitted',
        ];
    }

    public function saveAsDraft()
    {
        $this->status = 'draft';

        // Do not validate on draft save
        $timesheet = Timesheet::create([
            'user_id' => Auth::id(),
            'week_starting' => $this->week_starting,
            'days' => $this->days,
            'expenses_materials' => $this->expenses_materials,
            'expenses_other' => $this->expenses_other,
            'expenses_total' => $this->expenses_total,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Draft timesheet saved.');

        return redirect()->route('timesheets.show', $timesheet);
    }

    public function store()
    {
        $this->status = 'submitted';

        // Only validate on final submission
        $this->validate();

        $timesheet = Timesheet::create([
            'user_id' => Auth::id(),
            'week_starting' => $this->week_starting,
            'days' => $this->days,
            'expenses_materials' => $this->expenses_materials,
            'expenses_other' => $this->expenses_other,
            'expenses_total' => $this->expenses_total,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Timesheet submitted successfully.');

        return redirect()->route('timesheets.show', $timesheet);
    }

    public function render()
    {
        return view('livewire.timesheets.create', [
            'user_name' => Auth::user()->name,
        ]);
    }
}
