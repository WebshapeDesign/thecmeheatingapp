<?php

namespace App\Livewire\VanLogs;

use App\Models\VanLog;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public VanLog $vanLog;

    public $mileage;
    public $oil_checked, $oil_action;
    public $water_checked, $water_action;
    public $tyres_checked, $tyres_action;
    public $wash_checked, $wash_action;
    public $vehicle_defects;

    public $ladder_checked, $ladder_signed, $ladder_defects;
    public $vacuum_checked, $vacuum_signed, $vacuum_defects;
    public $tools_checked, $tools_signed, $tools_defects;
    public $extinguisher_checked, $extinguisher_signed, $extinguisher_defects;

    public $ppe = [];

    public function mount(VanLog $vanLog)
    {
        $this->vanLog = $vanLog;

        // Populate simple fields
        $this->mileage = $vanLog->mileage;
        $this->oil_checked = $vanLog->oil_checked;
        $this->oil_action = $vanLog->oil_action;
        $this->water_checked = $vanLog->water_checked;
        $this->water_action = $vanLog->water_action;
        $this->tyres_checked = $vanLog->tyres_checked;
        $this->tyres_action = $vanLog->tyres_action;
        $this->wash_checked = $vanLog->wash_checked;
        $this->wash_action = $vanLog->wash_action;
        $this->vehicle_defects = $vanLog->vehicle_defects;

        $this->ladder_checked = $vanLog->ladder_checked;
        $this->ladder_signed = $vanLog->ladder_signed;
        $this->ladder_defects = $vanLog->ladder_defects;
        $this->vacuum_checked = $vanLog->vacuum_checked;
        $this->vacuum_signed = $vanLog->vacuum_signed;
        $this->vacuum_defects = $vanLog->vacuum_defects;
        $this->tools_checked = $vanLog->tools_checked;
        $this->tools_signed = $vanLog->tools_signed;
        $this->tools_defects = $vanLog->tools_defects;
        $this->extinguisher_checked = $vanLog->extinguisher_checked;
        $this->extinguisher_signed = $vanLog->extinguisher_signed;
        $this->extinguisher_defects = $vanLog->extinguisher_defects;

        // Populate PPE group
        $ppe_items = [
            'first_aid', 'fire_extinguisher', 'accident_book', 'eye_wash',
            'company_id', 'safety_boots', 'safety_goggles', 'hi_viz',
            'gloves', 'hard_hat'
        ];

        foreach ($ppe_items as $item) {
            $this->ppe[$item] = [
                'required' => $vanLog["{$item}_required"],
                'actual' => $vanLog["{$item}_actual"],
                'checked' => $vanLog["{$item}_checked"],
                'signed' => $vanLog["{$item}_signed"],
                'defects' => $vanLog["{$item}_defects"],
            ];
        }
    }

    protected function rules()
    {
        return [
            'mileage' => 'required|numeric|min:0',

            'oil_checked' => 'required|boolean',
            'water_checked' => 'required|boolean',
            'tyres_checked' => 'required|boolean',
            'wash_checked' => 'required|boolean',
            'vehicle_defects' => 'nullable|string',

            'ladder_checked' => 'required|boolean',
            'ladder_signed' => 'required|boolean',
            'vacuum_checked' => 'required|boolean',
            'vacuum_signed' => 'required|boolean',
            'tools_checked' => 'required|boolean',
            'tools_signed' => 'required|boolean',
            'extinguisher_checked' => 'required|boolean',
            'extinguisher_signed' => 'required|boolean',

            'ppe.*.actual' => 'required|integer|min:0',
            'ppe.*.checked' => 'required|boolean',
            'ppe.*.signed' => 'required|boolean',
            'ppe.*.defects' => 'nullable|string',
        ];
    }

    public function update()
    {
        $this->validate();

        $data = [
            'mileage' => $this->mileage,
            'oil_checked' => $this->oil_checked,
            'oil_action' => $this->oil_action,
            'water_checked' => $this->water_checked,
            'water_action' => $this->water_action,
            'tyres_checked' => $this->tyres_checked,
            'tyres_action' => $this->tyres_action,
            'wash_checked' => $this->wash_checked,
            'wash_action' => $this->wash_action,
            'vehicle_defects' => $this->vehicle_defects,

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

        foreach ($this->ppe as $key => $values) {
            foreach ($values as $subkey => $val) {
                $data["{$key}_{$subkey}"] = $val;
            }
        }

        $this->vanLog->update($data);

        session()->flash('message', 'Van Log updated successfully.');

        return redirect()->route('vanlogs.show', $this->vanLog);
    }

    public function render()
    {
        return view('livewire.vanlogs.edit');
    }
}
