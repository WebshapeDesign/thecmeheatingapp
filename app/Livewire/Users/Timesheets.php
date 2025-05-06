<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class Timesheets extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.users.timesheets', [
            'timesheets' => $this->user->timesheets()->latest()->get(),
        ]);
    }
}
