<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Request Holiday') }}
            </h2>
            <a href="{{ route('holidays.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Holidays') }}
            </a>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:heading size="xl">New Holiday Request</flux:heading>
    </div>

    <flux:separator variant="subtle" class="my-8" />

    <section class="w-full">
        <x-settings.layout :heading="__('Holiday Details')" :subheading="__('Submit a request for upcoming leave')">
            <form wire:submit.prevent="store" class="my-6 w-full space-y-10">

                {{-- User and Date Requested --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if(auth()->user()->isAdmin())
                        <flux:select
                            wire:model="user_id"
                            :label="__('Select User')"
                            :error="$errors->first('user_id')"
                        >
                            <option value="">{{ __('Choose a User') }}</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </flux:select>
                    @else
                        <flux:input
                            :value="auth()->user()->name"
                            :label="__('Name')"
                            disabled
                        />
                    @endif

                    <flux:input
                        wire:model="date_requested"
                        :label="__('Date Requested')"
                        disabled
                    />
                </div>

                {{-- Dates & Number of Days --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <flux:input
                        wire:model="holiday_start_date"
                        type="date"
                        :label="__('Holiday Start Date')"
                        :error="$errors->first('holiday_start_date')"
                    />
                    <flux:input
                        wire:model="holiday_end_date"
                        type="date"
                        :label="__('Holiday End Date')"
                        :error="$errors->first('holiday_end_date')"
                    />
                    <flux:input
                        wire:model="number_of_days"
                        type="number"
                        min="1"
                        step="1"
                        :label="__('Number of Days')"
                        :error="$errors->first('number_of_days')"
                    />
                </div>

                {{-- Holiday Days Remaining --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input
                        :value="$remaining_days"
                        type="number"
                        disabled
                        :label="__('Holiday Days Remaining')"
                    />
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end mt-6">
                    <flux:button type="submit" color="primary">
                        {{ __('Submit Holiday Request') }}
                    </flux:button>
                </div>

            </form>
        </x-settings.layout>
    </section>
</div>
