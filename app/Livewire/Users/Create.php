<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Vehicle;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    public $name = '';
    public $email = '';
    public $mobile = '';
    public $password = '';
    public $role = 'user';
    public $vehicle_id;
    public $vehicles;

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'mobile' => ['nullable', 'string', 'max:255'],
        'password' => ['required', 'string', 'min:8'],
        'role' => ['required', 'string', 'in:user,admin'],
        'vehicle_id' => ['nullable', 'exists:vehicles,id'],
    ];

    public function mount()
    {
        $this->vehicles = Vehicle::whereNull('user_id')->get();
    }

    public function store()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        if ($this->vehicle_id) {
            Vehicle::where('id', $this->vehicle_id)->update([
                'user_id' => $user->id,
            ]);
        }

        session()->flash('message', 'User created successfully.');

        return redirect()->route('users.show', $user);
    }

    public function render()
    {
        return view('livewire.users.create');
    }
}
