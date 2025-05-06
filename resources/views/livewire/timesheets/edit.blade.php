<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Timesheet') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('timesheets.show', $timesheet) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Timesheet') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Edit Timesheet</flux:heading>
        <flux:button as="a" href="{{ route('timesheets.show', $timesheet) }}" icon="arrow-left" variant="primary">
            {{ __('View Timesheet') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="my-8" />
    <div class="h-8"></div>

    <section class="w-full">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-12">
            <div class="md:col-span-1 flex flex-col items-start space-y-2">
                <flux:button as="a" href="{{ route('timesheets.index') }}" icon="arrow-left" variant="subtle" size="sm">
                    {{ __('Back to Timesheets') }}
                </flux:button>
            </div>

            <flux:separator class="md:hidden" />

            <div class="md:col-span-2">
                <form wire:submit.prevent="update" class="my-6 w-full max-w-full space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <flux:input
                                wire:model="week_starting"
                                :label="__('Week Starting')"
                                disabled
                            />
                        </div>
                        <div>
                            <flux:input
                                :value="$timesheet->user->name"
                                :label="__('User Name')"
                                disabled
                            />
                        </div>
                    </div>

                    @foreach ($days as $index => $day)
                        <div class="border-t pt-6 space-y-4">
                            <flux:heading size="lg">{{ $day['label'] }} ({{ $day['date'] }})</flux:heading>

                            @foreach ($day['entries'] as $entryIndex => $entry)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <flux:input
                                        wire:model="days.{{ $index }}.entries.{{ $entryIndex }}.time"
                                        type="time"
                                        :label="__('Time')"
                                    />
                                    <flux:input
                                        wire:model="days.{{ $index }}.entries.{{ $entryIndex }}.description"
                                        :label="__('Description')"
                                    />
                                </div>
                            @endforeach

                            <flux:button type="button" icon="plus" size="sm" wire:click="addEntry({{ $index }})">
                                {{ __('Add Row') }}
                            </flux:button>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                                <flux:input
                                    wire:model="days.{{ $index }}.total_hours"
                                    type="number"
                                    min="0"
                                    :label="__('Total Hours')"
                                />
                                <flux:input
                                    wire:model="days.{{ $index }}.travel_hours"
                                    type="number"
                                    min="0"
                                    :label="__('Travel Hours')"
                                />
                            </div>
                        </div>
                    @endforeach

                    <div class="border-t pt-6">
                        <flux:heading size="lg">{{ __('Expenses') }}</flux:heading>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                            <flux:input
                                wire:model="expenses_materials"
                                type="number"
                                step="0.01"
                                min="0"
                                :label="__('Materials (£)')"
                            />
                            <flux:input
                                wire:model="expenses_other"
                                type="number"
                                step="0.01"
                                min="0"
                                :label="__('Other (£)')"
                            />
                            <flux:input
                                wire:model="expenses_total"
                                type="number"
                                step="0.01"
                                :label="__('Total (£)')"
                                disabled
                            />
                        </div>
                    </div>

                    <div class="flex justify-end mt-6 space-x-4">
                        <flux:button type="submit" color="primary">
                            {{ __('Save Changes') }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
