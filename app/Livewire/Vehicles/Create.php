<?php

namespace App\Livewire\Vehicles;

use App\Models\User;
use App\Models\Vehicle;
use Livewire\Component;

class Create extends Component
{
    public $registration_number = '';
    public $make = '';
    public $model = '';
    public $user_id = '';
    public $mileage;

    public $users;

    public function mount()
    {
        $this->users = User::orderBy('name')->get();
    }

    protected function rules()
    {
        return [
            'registration_number' => ['required', 'string', 'max:255', 'unique:vehicles'],
            'make' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'user_id' => ['nullable', 'exists:users,id'],
            'mileage' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function store()
    {
        $this->validate();

        $vehicle = Vehicle::create([
            'registration_number' => $this->registration_number,
            'make' => $this->make,
            'model' => $this->model,
            'user_id' => $this->user_id ?: null,
            'mileage' => $this->mileage,
        ]);

        session()->flash('message', 'Vehicle created successfully.');

        return redirect()->route('vehicles.show', $vehicle);
    }

    public function render()
    {
        return view('livewire.vehicles.create');
    }
}
