<?php

namespace App\Livewire\MileageLogs;

use App\Models\MileageLog;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public MileageLog $mileageLog;

    public $entries = [];

    public function mount(MileageLog $mileageLog)
    {
        $this->mileageLog = $mileageLog;

        if ($mileageLog->status === 'submitted') {
            abort(403, 'This log has already been submitted and cannot be edited.');
        }

        $this->entries = $mileageLog->entries ?? [];
    }

    public function updatedEntries()
    {
        foreach ($this->entries as &$entry) {
            if (is_numeric($entry['start_mileage']) && is_numeric($entry['finish_mileage'])) {
                $entry['miles_driven'] = (int) $entry['finish_mileage'] - (int) $entry['start_mileage'];
            } else {
                $entry['miles_driven'] = '';
            }
        }
    }

    protected function rules()
    {
        return [
            'entries' => 'required|array|min:1',
            'entries.*.date' => 'required|date',
            'entries.*.time' => 'required|string',
            'entries.*.description' => 'required|string',
            'entries.*.location' => 'required|string',
            'entries.*.start_mileage' => 'required|numeric|min:0',
            'entries.*.finish_mileage' => 'required|numeric|min:0|gte:entries.*.start_mileage',
        ];
    }

    public function update()
    {
        $this->validate();

        $this->mileageLog->entries = $this->entries;
        $this->mileageLog->save();

        // Optionally update the associated vehicle mileage
        $vehicle = $this->mileageLog->vehicle;
        $last = end($this->entries);
        if (isset($last['finish_mileage']) && is_numeric($last['finish_mileage'])) {
            $vehicle->mileage = (int) $last['finish_mileage'];
            $vehicle->save();
        }

        session()->flash('message', 'Mileage Log updated successfully.');

        return redirect()->route('mileagelogs.show', $this->mileageLog);
    }

    public function submit()
    {
        $this->validate();

        $this->mileageLog->update([
            'entries' => $this->entries,
            'status' => 'submitted',
        ]);

        session()->flash('message', 'Mileage Log submitted successfully.');

        return redirect()->route('mileagelogs.show', $this->mileageLog);
    }

    public function render()
    {
        return view('livewire.mileagelogs.edit');
    }
}