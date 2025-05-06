<?php

namespace App\Livewire\MileageLogs;

use App\Models\MileageLog;
use Livewire\Component;

class Show extends Component
{
    public MileageLog $mileageLog;

    public function mount(MileageLog $mileageLog)
    {
        $this->mileageLog = $mileageLog;
    }

    public function render()
    {
        return view('livewire.mileagelogs.show');
    }
}
