<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Mileage Log') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('mileagelogs.show', $mileageLog) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Mileage Log') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Edit Mileage Log</flux:heading>
        <flux:button as="a" href="{{ route('mileagelogs.show', $mileageLog) }}" icon="arrow-left" variant="primary">
            {{ __('View Mileage Log') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="my-8" />
    <div class="h-8"></div>

    <section class="w-full">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-12">
            <div class="md:col-span-1 flex flex-col items-start space-y-2">
                <flux:button as="a" href="{{ route('mileagelogs.index') }}" icon="arrow-left" variant="subtle" size="sm">
                    {{ __('Back to Mileage Logs') }}
                </flux:button>
            </div>

            <flux:separator class="md:hidden" />

            <div class="md:col-span-2">
                <form wire:submit.prevent="update" class="my-6 w-full space-y-10">

                    {{-- Info --}}
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
                            <option value="submitted">{{ __('Submitted') }}</option>
                        </flux:select>
                    </div>

                    {{-- Mileage Entry Rows --}}
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
                                        <th class="px-4 py-2">Miles</th>
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
                                                <flux:input wire:model="entries.{{ $index }}.description" placeholder="e.g., Site B install" />
                                            </td>
                                            <td class="px-4 py-3">
                                                <flux:input wire:model="entries.{{ $index }}.location" placeholder="e.g., Hatfield" />
                                            </td>
                                            <td class="px-4 py-3">
                                                <flux:input type="number" wire:model="entries.{{ $index }}.start_mileage" />
                                            </td>
                                            <td class="px-4 py-3">
                                                <flux:input type="number" wire:model="entries.{{ $index }}.finish_mileage" />
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                {{ $entry['finish_mileage'] - $entry['start_mileage'] }}
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <flux:button type="button" size="sm" icon="trash" variant="destructive" wire:click="removeEntry({{ $index }})" />
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

                    {{-- Submit --}}
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
