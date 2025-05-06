<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Timesheet') }}
            </h2>
            <a href="{{ route('timesheets.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Timesheets') }}
            </a>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:heading size="xl">Create Timesheet</flux:heading>
    </div>

    <flux:separator variant="subtle" class="my-8" />

    <section class="w-full">
        <x-settings.layout :heading="__('Timesheet Details')" :subheading="__('Record your work and expenses for the week')">
            <form wire:submit.prevent="store" class="my-6 w-full space-y-10">

                {{-- Name and Week --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input
                        wire:model="user_name"
                        :label="__('Name')"
                        disabled
                    />
                    <flux:input
                        wire:model="week_starting"
                        :label="__('Week Starting (Sunday)')"
                        disabled
                    />
                </div>

                {{-- Day-wise Entries --}}
                @foreach ($days as $index => $day)
                    <div class="space-y-4">
                        <flux:heading size="md">{{ $day['label'] }} ({{ $day['date'] }})</flux:heading>

                        @if (!empty($day['entries']))
                            @foreach ($day['entries'] as $entryIndex => $entry)
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                    <div class="md:col-span-5">
                                        <flux:input
                                            wire:model="days.{{ $index }}.entries.{{ $entryIndex }}.time"
                                            type="time"
                                            :label="__('Time')"
                                            :error="$errors->first('days.' . $index . '.entries.' . $entryIndex . '.time')"
                                        />
                                    </div>
                                    <div class="md:col-span-6">
                                        <flux:input
                                            wire:model="days.{{ $index }}.entries.{{ $entryIndex }}.description"
                                            :label="__('Description')"
                                            placeholder="Job description..."
                                            :error="$errors->first('days.' . $index . '.entries.' . $entryIndex . '.description')"
                                        />
                                    </div>
                                    <div class="md:col-span-1">
                                        <flux:button type="button" size="sm" icon="trash" variant="destructive"
                                            wire:click="removeEntry({{ $index }}, {{ $entryIndex }})" />
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <flux:button type="button" icon="plus" size="sm" wire:click="addEntry({{ $index }})">
                            {{ __('Add Row') }}
                        </flux:button>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                            <flux:input
                                wire:model="days.{{ $index }}.total_hours"
                                type="number"
                                min="0"
                                :label="__('Total Hours')"
                                :error="$errors->first('days.' . $index . '.total_hours')"
                            />
                            <flux:input
                                wire:model="days.{{ $index }}.travel_hours"
                                type="number"
                                min="0"
                                :label="__('Travel Hours')"
                                :error="$errors->first('days.' . $index . '.travel_hours')"
                            />
                        </div>

                        <flux:separator variant="subtle" class="my-6" />
                    </div>
                @endforeach

                {{-- Expenses Section --}}
                <div class="space-y-4">
                    <flux:heading size="lg">{{ __('Expenses') }}</flux:heading>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <flux:input
                            wire:model="expenses_materials"
                            type="number"
                            step="0.01"
                            min="0"
                            :label="__('Materials (£)')"
                            :error="$errors->first('expenses_materials')"
                        />
                        <flux:input
                            wire:model="expenses_other"
                            type="number"
                            step="0.01"
                            min="0"
                            :label="__('Other (£)')"
                            :error="$errors->first('expenses_other')"
                        />
                        <flux:input
                            wire:model="expenses_total"
                            type="number"
                            step="0.01"
                            disabled
                            :label="__('Total (£)')"
                        />
                    </div>
                </div>

                {{-- Save Buttons --}}
                <div class="flex justify-end gap-4 mt-6">
                    <flux:button type="button" color="gray" wire:click="saveAsDraft">
                        {{ __('Save Draft') }}
                    </flux:button>
                    <flux:button type="submit" color="primary">
                        {{ __('Submit Timesheet') }}
                    </flux:button>
                </div>

            </form>
        </x-settings.layout>
    </section>
</div>
