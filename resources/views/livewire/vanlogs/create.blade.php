<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Van Log') }}
            </h2>
            <a href="{{ route('vanlogs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Van Logs') }}
            </a>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:heading size="xl">Create Van Log</flux:heading>
    </div>

    <flux:separator variant="subtle" class="my-8" />

    <section class="w-full">
        <x-settings.layout :heading="__('Van Log Details')" :subheading="__('Record your weekly van log details below')">
            <form wire:submit="store" class="my-6 w-full space-y-10">
                {{-- Vehicle & User Context --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                <div>
    <flux:text class="text-sm font-medium text-gray-700">{{ __('Vehicle Registration') }}</flux:text>
    <flux:text class="mt-1">{{ $vehicle->registration_number }}</flux:text>
</div>

<div>
    <flux:text class="text-sm font-medium text-gray-700">{{ __('Driver Name') }}</flux:text>
    <flux:text class="mt-1">{{ auth()->user()->name }}</flux:text>
</div>

                    <flux:input
                        wire:model="week_starting"
                        :label="__('Week Starting')"
                        disabled
                    />

                    <flux:input
                        wire:model="mileage"
                        type="number"
                        :label="__('Mileage')"
                        disabled
                    />
                </div>

                {{-- Vehicle Checks Section --}}
                <div>
                    <flux:heading size="lg">Vehicle Checks</flux:heading>
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full border border-zinc-200 text-sm">
                            <thead>
                                <tr class="bg-zinc-50 dark:bg-zinc-800">
                                    <th class="text-left px-4 py-2">Check</th>
                                    <th class="text-left px-4 py-2">Action Taken / Required</th>
                                    <th class="text-center px-4 py-2">Completed</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                                @foreach (['oil' => 'Oil Level', 'water' => 'Water Level', 'tyres' => 'Tyre Pressure & Spare', 'wash' => 'Windscreen Wash'] as $key => $label)
                                    <tr>
                                        <td class="px-4 py-3">{{ $label }}</td>
                                        <td class="px-4 py-3">
                                            <flux:input
                                                wire:model="{{ $key }}_action"
                                                placeholder="Optional notes"
                                            />
                                        </td>
                                        <td class="text-center px-4 py-3">
                                            <flux:checkbox wire:model="{{ $key }}_checked" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <flux:textarea
                            wire:model="vehicle_defects"
                            :label="__('Vehicle Defects')"
                            placeholder="List any defects here..."
                        />
                    </div>
                </div>

                {{-- Vehicle Equipment Section --}}
                <div>
                    <flux:heading size="lg">Vehicle Equipment</flux:heading>
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full border border-zinc-200 text-sm">
                            <thead>
                                <tr class="bg-zinc-50 dark:bg-zinc-800">
                                    <th class="text-left px-4 py-2">Item</th>
                                    <th class="text-center px-4 py-2">Visual Check</th>
                                    <th class="text-center px-4 py-2">Signed</th>
                                    <th class="text-left px-4 py-2">Defects</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                                @foreach (['ladder' => 'Ladder/Steps', 'vacuum' => 'Vacuum', 'tools' => 'Tools on Van', 'extinguisher' => 'Fire Extinguisher Expiry Date'] as $key => $label)
                                    <tr>
                                        <td class="px-4 py-3">{{ $label }}</td>
                                        <td class="text-center px-4 py-3"><flux:checkbox wire:model="{{ $key }}_checked" /></td>
                                        <td class="text-center px-4 py-3"><flux:checkbox wire:model="{{ $key }}_signed" /></td>
                                        <td class="px-4 py-3">
                                            <flux:input wire:model="{{ $key }}_defects" placeholder="Optional defects" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- PPE / Health and Safety Section --}}
                <div>
                    <flux:heading size="lg">PPE / Health & Safety Equipment</flux:heading>
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full border border-zinc-200 text-sm">
                            <thead>
                                <tr class="bg-zinc-50 dark:bg-zinc-800">
                                    <th class="text-left px-4 py-2">Item</th>
                                    <th class="text-center px-4 py-2">No. Required</th>
                                    <th class="text-center px-4 py-2">Actual</th>
                                    <th class="text-center px-4 py-2">Visual Check</th>
                                    <th class="text-center px-4 py-2">Signed</th>
                                    <th class="text-left px-4 py-2">Defects</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                                @foreach ($ppe_items as $key => $label)
                                    <tr>
                                        <td class="px-4 py-3">{{ $label }}</td>
                                        <td class="text-center px-4 py-3">1</td>
                                        <td class="text-center px-4 py-3">
                                            <flux:input
                                                wire:model="ppe.{{ $key }}.actual"
                                                type="number"
                                                min="0"
                                                class="w-16 text-center"
                                            />
                                        </td>
                                        <td class="text-center px-4 py-3">
                                            <flux:checkbox wire:model="ppe.{{ $key }}.checked" />
                                        </td>
                                        <td class="text-center px-4 py-3">
                                            <flux:checkbox wire:model="ppe.{{ $key }}.signed" />
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:input
                                                wire:model="ppe.{{ $key }}.defects"
                                                placeholder="Optional defects"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end mt-6">
                    <flux:button type="submit" color="primary">
                        {{ __('Submit Van Log') }}
                    </flux:button>
                </div>
            </form>
        </x-settings.layout>
    </section>
</div>
