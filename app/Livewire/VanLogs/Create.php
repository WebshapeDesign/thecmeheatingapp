<?php

namespace App\Livewire\VanLogs;

use App\Models\VanLog;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $vehicle;
    public $week_starting;
    public $mileage;

    // PPE Labels for Display
    public array $ppe_items = [
        'first_aid' => 'First Aid',
        'fire_extinguisher' => 'Fire Extinguisher',
        'accident_book' => 'Accident Book',
        'eye_wash' => 'Eye Wash',
        'company_id' => 'Company ID',
        'safety_boots' => 'Safety Boots',
        'safety_goggles' => 'Safety Goggles',
        'hi_viz' => 'Hi Vis Jacket',
        'gloves' => 'Gloves',
        'hard_hat' => 'Hard Hat',
    ];

    // Vehicle Checks
    public $oil_checked = false;
    public $oil_action = '';
    public $water_checked = false;
    public $water_action = '';
    public $tyres_checked = false;
    public $tyres_action = '';
    public $wash_checked = false;
    public $wash_action = '';
    public $vehicle_defects = '';

    // Equipment Checks
    public $ladder_checked = false;
    public $ladder_signed = false;
    public $ladder_defects = '';
    public $vacuum_checked = false;
    public $vacuum_signed = false;
    public $vacuum_defects = '';
    public $tools_checked = false;
    public $tools_signed = false;
    public $tools_defects = '';
    public $extinguisher_checked = false;
    public $extinguisher_signed = false;
    public $extinguisher_defects = '';

    // PPE Check Structure
    public $ppe = [];

    public function mount()
    {
        $this->vehicle = Auth::user()->vehicle;

        if (!$this->vehicle) {
            abort(403, 'You do not have a vehicle assigned.');
        }

        $this->mileage = $this->vehicle->mileage;
        $this->week_starting = Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        foreach ($this->ppe_items as $key => $label) {
            $this->ppe[$key] = [
                'required' => 1,
                'actual' => 0,
                'checked' => false,
                'signed' => false,
                'defects' => '',
            ];
        }
    }

    protected function rules(): array
    {
        return [
            // Vehicle Checks
            'oil_checked' => 'required|boolean',
            'water_checked' => 'required|boolean',
            'tyres_checked' => 'required|boolean',
            'wash_checked' => 'required|boolean',
            'vehicle_defects' => 'nullable|string',

            // Equipment Checks
            'ladder_checked' => 'required|boolean',
            'ladder_signed' => 'required|boolean',
            'vacuum_checked' => 'required|boolean',
            'vacuum_signed' => 'required|boolean',
            'tools_checked' => 'required|boolean',
            'tools_signed' => 'required|boolean',
            'extinguisher_checked' => 'required|boolean',
            'extinguisher_signed' => 'required|boolean',

            // PPE Checks
            'ppe.*.actual' => 'required|integer|min:0',
            'ppe.*.checked' => 'required|boolean',
            'ppe.*.signed' => 'required|boolean',
            'ppe.*.defects' => 'nullable|string',
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'vehicle_id' => $this->vehicle->id,
            'user_id' => Auth::id(),
            'week_starting' => $this->week_starting,
            'mileage' => $this->mileage,

            // Vehicle Checks
            'oil_checked' => $this->oil_checked,
            'oil_action' => $this->oil_action,
            'water_checked' => $this->water_checked,
            'water_action' => $this->water_action,
            'tyres_checked' => $this->tyres_checked,
            'tyres_action' => $this->tyres_action,
            'wash_checked' => $this->wash_checked,
            'wash_action' => $this->wash_action,
            'vehicle_defects' => $this->vehicle_defects,

            // Equipment Checks
            'ladder_checked' => $this->ladder_checked,
            'ladder_signed' => $this->ladder_signed,
            'ladder_defects' => $this->ladder_defects,
            'vacuum_checked' => $this->vacuum_checked,
            'vacuum_signed' => $this->vacuum_signed,
            'vacuum_defects' => $this->vacuum_defects,
            'tools_checked' => $this->tools_checked,
            'tools_signed' => $this->tools_signed,
            'tools_defects' => $this->tools_defects,
            'extinguisher_checked' => $this->extinguisher_checked,
            'extinguisher_signed' => $this->extinguisher_signed,
            'extinguisher_defects' => $this->extinguisher_defects,
        ];

        // Flatten PPE into $data
        foreach ($this->ppe as $key => $values) {
            foreach ($values as $subkey => $val) {
                $data["{$key}_{$subkey}"] = $val;
            }
        }

        $log = VanLog::create($data);

        session()->flash('message', 'Van Log created successfully.');
        return redirect()->route('vanlogs.show', $log);
    }

    public function render()
    {
        return view('livewire.vanlogs.create', [
            'ppe_items' => $this->ppe_items,
        ]);
    }
}
