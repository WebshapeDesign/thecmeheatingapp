<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Holiday Request') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('holidays.show', $holiday) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Holiday') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Edit Holiday Request</flux:heading>
        <flux:button as="a" href="{{ route('holidays.show', $holiday) }}" icon="arrow-left" variant="primary">
            {{ __('View Holiday') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="my-8" />
    <div class="h-8"></div>

    <section class="w-full">
        <form wire:submit.prevent="update" class="space-y-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input :value="$user_name" :label="__('User Name')" disabled />
                <flux:input :value="$holiday->date_requested->format('d/m/Y')" :label="__('Date Requested')" disabled />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <flux:input
                    wire:model="holiday_start_date"
                    type="date"
                    :label="__('Holiday Start Date')"
                />
                <flux:input
                    wire:model="holiday_end_date"
                    type="date"
                    :label="__('Holiday End Date')"
                />
                <flux:input
                    wire:model="number_of_days"
                    type="number"
                    min="1"
                    step="1"
                    :label="__('Number of Days')"
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input
                    :value="$holiday_days_remaining"
                    type="number"
                    disabled
                    :label="__('Holiday Days Remaining')"
                />
            </div>

            <div class="flex justify-end mt-6 space-x-4">
                <flux:button type="submit" color="primary">
                    {{ __('Save Changes') }}
                </flux:button>

                @if(auth()->user()->isAdmin() && $holiday->status === 'requested')
                    <flux:button type="button" wire:click="approveHoliday" color="success">
                        {{ __('Approve Request') }}
                    </flux:button>
                @endif
            </div>
        </form>
    </section>
</div>
