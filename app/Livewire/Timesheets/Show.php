<?php

namespace App\Livewire\Timesheets;

use App\Models\Timesheet;
use Livewire\Component;

class Show extends Component
{
    public Timesheet $timesheet;

    public function mount(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }

    public function render()
    {
        return view('livewire.timesheets.show', [
            'days' => $this->timesheet->days ?? [],
            'expenses_materials' => $this->timesheet->expenses_materials,
            'expenses_other' => $this->timesheet->expenses_other,
            'expenses_total' => $this->timesheet->expenses_total,
        ]);
    }
}
