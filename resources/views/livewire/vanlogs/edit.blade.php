<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Van Log') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('vanlogs.show', $vanlog) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Van Log') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Edit Van Log</flux:heading>
        <flux:button as="a" href="{{ route('vanlogs.show', $vanlog) }}" icon="arrow-left" variant="primary">
            {{ __('View Van Log') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="my-8" />
    <div class="h-8"></div>

    <section class="w-full">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-12">
            <div class="md:col-span-1 flex flex-col items-start space-y-2">
                <flux:button as="a" href="{{ route('vanlogs.index') }}" icon="arrow-left" variant="subtle" size="sm">
                    {{ __('Back to Van Logs') }}
                </flux:button>
            </div>

            <div class="md:col-span-2">
                <form wire:submit.prevent="update" class="my-6 w-full space-y-10">

                    {{-- Basic info --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:input wire:model="vehicle_registration" :label="__('Vehicle Registration')" disabled />
                        <flux:input wire:model="driver_name" :label="__('Driver Name')" disabled />
                        <flux:input wire:model="week_starting" :label="__('Week Starting')" disabled />
                        <flux:input wire:model="mileage" :label="__('Mileage')" type="number" disabled />
                    </div>

                    {{-- Vehicle Checks --}}
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
                                                <flux:input wire:model="{{ $key }}_action" placeholder="Optional notes" />
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

                    {{-- Equipment Checks --}}
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

                    {{-- PPE / Health & Safety --}}
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
                                                <flux:input wire:model="ppe.{{ $key }}.defects" placeholder="Optional defects" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Save Changes --}}
                    <div class="flex justify-end mt-6">
                        <flux:button type="submit" color="primary">
                            {{ __('Save Changes') }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
