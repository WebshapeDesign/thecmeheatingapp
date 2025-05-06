<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class Holidays extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.users.holidays', [
            'holidays' => $this->user->holidays()->latest()->get(),
        ]);
    }
}
