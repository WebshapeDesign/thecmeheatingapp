<?php

namespace App\Livewire\VanLogs;

use Livewire\Component;
use App\Models\VanLog;

class Show extends Component
{
    public VanLog $vanlog;

    public function mount(VanLog $vanlog)
    {
        // Eager-load the relationships for display
        $this->vanlog->load(['vehicle', 'user']);
    }

    public function render()
    {
        return view('livewire.vanlogs.show');
    }
}
