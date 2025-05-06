<?php

namespace App\Livewire\Vehicles;

use App\Models\User;
use App\Models\Vehicle;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public Vehicle $vehicle;

    public $registration_number;
    public $make;
    public $model;
    public $user_id;
    public $mileage;

    public $users;

    public function mount(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;

        $this->registration_number = $vehicle->registration_number;
        $this->make = $vehicle->make;
        $this->model = $vehicle->model;
        $this->user_id = $vehicle->user_id;
        $this->mileage = $vehicle->mileage;

        $this->users = User::orderBy('name')->get();
    }

    protected function rules()
    {
        return [
            'registration_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('vehicles')->ignore($this->vehicle->id),
            ],
            'make' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'user_id' => ['nullable', 'exists:users,id'],
            'mileage' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->vehicle->update([
            'registration_number' => $this->registration_number,
            'make' => $this->make,
            'model' => $this->model,
            'user_id' => $this->user_id ?: null,
            'mileage' => $this->mileage,
        ]);

        session()->flash('message', 'Vehicle updated successfully.');

        return redirect()->route('vehicles.show', $this->vehicle);
    }

    public function render()
    {
        return view('livewire.vehicles.edit');
    }
}
