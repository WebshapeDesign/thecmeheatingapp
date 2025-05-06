<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Holiday Request Details') }} for {{ $holiday->user->name }}
            </h2>
            <div class="flex space-x-2">
                @can('update', $holiday)
                    @if ($holiday->status !== 'approved' || auth()->user()->isAdmin())
                        <a href="{{ route('holidays.edit', $holiday) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Edit Request') }}
                        </a>
                    @endif
                @endcan
                <a href="{{ route('holidays.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Holidays') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Holiday Request for {{ $holiday->user->name }}</flux:heading>
        @can('update', $holiday)
            @if ($holiday->status !== 'approved' && auth()->user()->isAdmin())
                <form method="post" wire:submit.prevent="approve">
                    @csrf
                    <flux:button type="button" wire:click="approveHoliday" icon="check" variant="primary">
    {{ __('Approve Request') }}
</flux:button>
                </form>
            @endif
        @endcan
    </div>

    <flux:separator variant="subtle" class="my-8" />
    <div class="h-8"></div>

    <section class="w-full">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-12">
            <div class="md:col-span-1 flex flex-col items-start space-y-2">
                <flux:button as="a" href="{{ route('holidays.index') }}" icon="arrow-left" variant="subtle" size="sm">
                    {{ __('Back to Holidays') }}
                </flux:button>
            </div>

            <flux:separator class="md:hidden" />

            <div class="md:col-span-2 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('User') }}</flux:text>
                        <flux:text class="mt-1">{{ $holiday->user->name }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Date Requested') }}</flux:text>
                        <flux:text class="mt-1">{{ \Carbon\Carbon::parse($holiday->date_requested)->format('d/m/Y') }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Holiday Start Date') }}</flux:text>
                        <flux:text class="mt-1">{{ \Carbon\Carbon::parse($holiday->holiday_start_date)->format('l, jS F Y') }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Holiday End Date') }}</flux:text>
                        <flux:text class="mt-1">{{ \Carbon\Carbon::parse($holiday->holiday_end_date)->format('l, jS F Y') }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Number of Days Requested') }}</flux:text>
                        <flux:text class="mt-1">{{ $holiday->number_of_days }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Status') }}</flux:text>
                        <flux:badge
                            :color="match($holiday->status) {
                                'approved' => 'green',
                                'submitted' => 'yellow',
                                'rejected' => 'red',
                                default => 'gray'
                            }"
                            size="sm"
                            inset="top bottom"
                            class="mt-1"
                        >
                            {{ ucfirst($holiday->status) }}
                        </flux:badge>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Holiday Days Remaining') }}</flux:text>
                        <flux:text class="mt-1">
                            {{ $holiday->user->holiday_days_remaining }}
                        </flux:text>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
