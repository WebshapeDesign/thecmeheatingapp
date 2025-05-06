<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Timesheet Details') }}
            </h2>
            <div class="flex space-x-2">
                @can('update', $timesheet)
                    <a href="{{ route('timesheets.edit', $timesheet) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Edit Timesheet') }}
                    </a>
                @endcan
                <a href="{{ route('timesheets.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Timesheets') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Timesheet: Week of {{ \Carbon\Carbon::parse($timesheet->week_starting)->format('j M Y') }}</flux:heading>
        @can('update', $timesheet)
            <flux:button as="a" href="{{ route('timesheets.edit', $timesheet) }}" icon="pencil" variant="primary">
                {{ __('Edit Timesheet') }}
            </flux:button>
        @endcan
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

            <div class="md:col-span-2 space-y-8">
                {{-- User & Week Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('User') }}</flux:text>
                        <flux:text class="mt-1">{{ $timesheet->user->name }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Week Starting') }}</flux:text>
                        <flux:text class="mt-1">{{ \Carbon\Carbon::parse($timesheet->week_starting)->format('l, jS F Y') }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Status') }}</flux:text>
                        <flux:badge
                            :color="$timesheet->status === 'submitted' ? 'green' : 'yellow'"
                            size="sm"
                            inset="top bottom"
                            class="mt-1"
                        >
                            {{ ucfirst($timesheet->status) }}
                        </flux:badge>
                    </div>
                </div>

                {{-- Daily Entries --}}
                <div class="space-y-6">
                    @foreach ($timesheet->days as $day)
                        @if (!empty($day))
                            <div>
                                <flux:heading size="lg">{{ $day['label'] ?? 'Day' }} ({{ $day['date'] ?? '' }})</flux:heading>
                                @if (!empty($day['entries']))
                                    <div class="mt-2">
                                        <table class="min-w-full border border-zinc-200 text-sm">
                                            <thead>
                                                <tr class="bg-zinc-50 dark:bg-zinc-800">
                                                    <th class="px-4 py-2">Time</th>
                                                    <th class="px-4 py-2">Description</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                                                @foreach ($day['entries'] as $entry)
                                                    <tr>
                                                        <td class="px-4 py-2">{{ $entry['time'] ?? '—' }}</td>
                                                        <td class="px-4 py-2">{{ $entry['description'] ?? '—' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                <div class="mt-2 flex gap-4 text-sm text-gray-700">
                                    <span><strong>Total Hours:</strong> {{ $day['total_hours'] ?? 0 }}</span>
                                    <span><strong>Travel Hours:</strong> {{ $day['travel_hours'] ?? 0 }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Expenses Section --}}
                <div>
                    <flux:heading size="lg">Expenses</flux:heading>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Materials (£)') }}</flux:text>
                            <flux:text class="mt-1">£{{ number_format($timesheet->expenses_materials ?? 0, 2) }}</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Other (£)') }}</flux:text>
                            <flux:text class="mt-1">£{{ number_format($timesheet->expenses_other ?? 0, 2) }}</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Total (£)') }}</flux:text>
                            <flux:text class="mt-1 font-semibold">£{{ number_format($timesheet->expenses_total ?? 0, 2) }}</flux:text>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
