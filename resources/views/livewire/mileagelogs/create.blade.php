<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Mileage Log') }}
            </h2>
            <a href="{{ route('mileagelogs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Mileage Logs') }}
            </a>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:heading size="xl">Create Mileage Log</flux:heading>
    </div>

    <flux:separator variant="subtle" class="my-8" />

    <section class="w-full">
        <x-settings.layout 
            :heading="__('Mileage Log Details')" 
            :subheading="__('Record weekly mileage entries for this vehicle')"
        >
            <form wire:submit.prevent="store" class="my-6 w-full space-y-10">

                {{-- Vehicle & Week Info --}}
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
                    <flux:select wire:model="status" :label="__('Status')">
                        <option value="draft">{{ __('Draft') }}</option>
                        <option value="submitted">{{ __('Submit Now') }}</option>
                    </flux:select>
                </div>

                {{-- Table for Mileage Entries --}}
                <div>
                    <flux:heading size="lg">Mileage Entries</flux:heading>
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full border border-zinc-200 text-sm">
                            <thead>
                                <tr class="bg-zinc-50 dark:bg-zinc-800">
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Time</th>
                                    <th class="px-4 py-2">Description</th>
                                    <th class="px-4 py-2">Location</th>
                                    <th class="px-4 py-2">Start Mileage</th>
                                    <th class="px-4 py-2">Finish Mileage</th>
                                    <th class="px-4 py-2">Miles Driven</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                                @foreach ($entries as $index => $entry)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <flux:input type="date" wire:model="entries.{{ $index }}.date" />
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:input type="time" wire:model="entries.{{ $index }}.time" />
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:input wire:model="entries.{{ $index }}.description" placeholder="e.g., Job at site A" />
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:input wire:model="entries.{{ $index }}.location" placeholder="e.g., Watford" />
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:input type="number" min="0" wire:model="entries.{{ $index }}.start_mileage" />
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:input type="number" min="0" wire:model="entries.{{ $index }}.finish_mileage" />
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @php
                                                $start = (int) ($entry['start_mileage'] ?? 0);
                                                $finish = (int) ($entry['finish_mileage'] ?? 0);
                                            @endphp
                                            {{ $finish >= $start ? $finish - $start : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <flux:button type="button" size="sm" icon="trash" variant="subtle" wire:click="removeEntry({{ $index }})" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <flux:button type="button" variant="outline" icon="plus" wire:click="addEntry">
                            {{ __('Add Row') }}
                        </flux:button>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end mt-6">
                    <flux:button type="submit" color="primary">
                        {{ __('Save Mileage Log') }}
                    </flux:button>
                </div>

            </form>
        </x-settings.layout>
    </section>
</div>
