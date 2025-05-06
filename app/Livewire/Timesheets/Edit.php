<?php

namespace App\Livewire\Timesheets;

use App\Models\Timesheet;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public Timesheet $timesheet;

    public $week_starting;
    public $days = [];
    public $expenses_materials = 0;
    public $expenses_other = 0;
    public $expenses_total = 0;
    public $status;

    public function mount(Timesheet $timesheet)
    {
        if (!Auth::user()->isAdmin() && $timesheet->user_id !== Auth::id()) {
            abort(403);
        }

        $this->timesheet = $timesheet;
        $this->week_starting = $timesheet->week_starting;
        $this->days = array_values($timesheet->days ?? []);
        $this->expenses_materials = $timesheet->expenses['materials'] ?? 0;
        $this->expenses_other = $timesheet->expenses['other'] ?? 0;
        $this->expenses_total = $timesheet->expenses['total'] ?? 0;
        $this->status = $timesheet->status;
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
            'days' => 'required|array|min:1',
            'days.*.label' => 'required|string',
            'days.*.date' => 'required|date',
            'days.*.entries' => 'array',
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

    public function update()
    {
        $this->validate();

        $this->timesheet->update([
            'days' => $this->days,
            'expenses' => [
                'materials' => $this->expenses_materials,
                'other' => $this->expenses_other,
                'total' => $this->expenses_total,
            ],
            'status' => $this->status,
        ]);

        session()->flash('message', 'Timesheet updated successfully.');

        return redirect()->route('timesheets.show', $this->timesheet);
    }

    public function addEntry($index)
    {
        $this->days[$index]['entries'][] = [
            'time' => '',
            'description' => '',
        ];
    }

    public function removeEntry($index, $entryIndex)
    {
        unset($this->days[$index]['entries'][$entryIndex]);
        $this->days[$index]['entries'] = array_values($this->days[$index]['entries']);
    }

    public function render()
    {
        return view('livewire.timesheets.edit');
    }
}
