<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Vehicle;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public User $user;

    public $name;
    public $email;
    public $mobile;
    public $password = '';
    public $role;
    public $vehicle_id;
    public $vehicles;

    public function mount(User $user)
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile = $user->mobile;
        $this->role = $user->role;
        $this->vehicle_id = optional($user->vehicle)->id;

        $this->vehicles = Vehicle::where(function ($query) use ($user) {
            $query->whereNull('user_id')
                  ->orWhere('user_id', $user->id);
        })->get();
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'mobile' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:user,admin'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'role' => $this->role,
        ]);

        if ($this->password) {
            $this->user->update([
                'password' => Hash::make($this->password),
            ]);
        }

        // Unlink any vehicle previously associated with this user
        Vehicle::where('user_id', $this->user->id)->update(['user_id' => null]);

        // Assign selected vehicle to this user (if any)
        if ($this->vehicle_id) {
            Vehicle::where('id', $this->vehicle_id)->update(['user_id' => $this->user->id]);
        }

        session()->flash('message', 'User updated successfully.');

        return redirect()->route('users.show', $this->user);
    }

    public function render()
    {
        return view('livewire.users.edit');
    }
}
