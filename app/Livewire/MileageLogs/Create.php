<?php

namespace App\Livewire\MileageLogs;

use App\Models\MileageLog;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $vehicle;
    public $week_starting;
    public $entries = [];

    public function mount()
    {
        $this->vehicle = Auth::user()->vehicle;

        if (! $this->vehicle) {
            abort(403, 'You do not have a vehicle assigned.');
        }

        $this->week_starting = Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        $this->entries = [[
            'date' => '',
            'time' => '',
            'description' => '',
            'location' => '',
            'start_mileage' => (int) $this->vehicle->mileage,
            'finish_mileage' => '',
            'miles_driven' => '',
        ]];
    }

    public function addEntry()
    {
        $last = end($this->entries);
        $startMileage = is_numeric($last['finish_mileage']) ? (int) $last['finish_mileage'] : (int) $last['start_mileage'];

        $this->entries[] = [
            'date' => '',
            'time' => '',
            'description' => '',
            'location' => '',
            'start_mileage' => $startMileage,
            'finish_mileage' => '',
            'miles_driven' => '',
        ];
    }

    public function removeEntry($index)
    {
        unset($this->entries[$index]);
        $this->entries = array_values($this->entries);
        $this->updatedEntries(); // re-calculate
    }

    public function updatedEntries()
    {
        foreach ($this->entries as $index => &$entry) {
            if (
                isset($entry['start_mileage'], $entry['finish_mileage']) &&
                is_numeric($entry['start_mileage']) &&
                is_numeric($entry['finish_mileage'])
            ) {
                $start = (int) $entry['start_mileage'];
                $finish = (int) $entry['finish_mileage'];
                $entry['miles_driven'] = $finish - $start;
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

    public function store()
    {
        $this->validate();

        // Recalculate just in case before saving
        $this->updatedEntries();

        $log = MileageLog::create([
            'vehicle_id' => $this->vehicle->id,
            'user_id' => Auth::id(),
            'week_starting' => $this->week_starting,
            'entries' => $this->entries,
            'status' => 'draft',
        ]);

        // Update vehicle mileage
        $last = end($this->entries);
        if (isset($last['finish_mileage']) && is_numeric($last['finish_mileage'])) {
            $this->vehicle->mileage = (int) $last['finish_mileage'];
            $this->vehicle->save();
        }

        session()->flash('message', 'Mileage Log created successfully.');

        return redirect()->route('mileagelogs.show', $log);
    }

    public function render()
    {
        return view('livewire.mileagelogs.create');
    }
}
