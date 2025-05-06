<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mileage Log Details') }}
            </h2>
            <div class="flex space-x-2">
                @can('update', $mileageLog)
                    <a href="{{ route('mileagelogs.edit', $mileageLog) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Edit Mileage Log') }}
                    </a>
                @endcan
                <a href="{{ route('mileagelogs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Mileage Logs') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Mileage Log for {{ $mileageLog->vehicle->registration_number }} (Week Starting {{ \Carbon\Carbon::parse($mileageLog->week_starting)->format('M j, Y') }})</flux:heading>
        @can('update', $mileageLog)
            <flux:button as="a" href="{{ route('mileagelogs.edit', $mileageLog) }}" icon="pencil" variant="primary">
                {{ __('Edit Mileage Log') }}
            </flux:button>
        @endcan
    </div>

    <flux:separator variant="subtle" class="my-8" />
    <div class="h-8"></div>

    <section class="w-full">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-12">
            <div class="md:col-span-1 flex flex-col items-start space-y-2">
                <flux:navlist>
                    <flux:navlist.group heading="Options" class="mt-4">
                        <flux:navlist.item :href="route('mileagelogs.index')" wire:navigate>
                            {{ __('Back to Mileage Logs') }}
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('vehicles.show', $mileageLog->vehicle)" wire:navigate>
                            {{ __('View Vehicle') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>
            </div>

            <flux:separator class="md:hidden" />

            <div class="md:col-span-2">
                <div class="my-6 w-full space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Week Starting') }}</flux:text>
                            <flux:text class="mt-1">{{ \Carbon\Carbon::parse($mileageLog->week_starting)->format('F j, Y') }}</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Vehicle') }}</flux:text>
                            <flux:text class="mt-1">{{ $mileageLog->vehicle->registration_number ?? '—' }}</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Driver') }}</flux:text>
                            <flux:text class="mt-1">{{ $mileageLog->user->name ?? '—' }}</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Total Miles') }}</flux:text>
                            <flux:text class="mt-1">{{ $mileageLog->total_miles ?? 0 }} miles</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Status') }}</flux:text>
                            <flux:text class="mt-1 capitalize">{{ $mileageLog->status }}</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Created At') }}</flux:text>
                            <flux:text class="mt-1">{{ $mileageLog->created_at->format('F j, Y g:i A') }}</flux:text>
                        </div>
                    </div>

                    {{-- Mileage Entries Table --}}
                    <div class="mt-10">
                        <flux:heading size="lg">Entries</flux:heading>
                        <div class="overflow-x-auto mt-4">
                            <table class="min-w-full border border-zinc-200 text-sm">
                                <thead class="bg-zinc-50 dark:bg-zinc-800">
                                    <tr>
                                        <th class="text-left px-4 py-2">Date</th>
                                        <th class="text-left px-4 py-2">Time</th>
                                        <th class="text-left px-4 py-2">Description</th>
                                        <th class="text-left px-4 py-2">Location</th>
                                        <th class="text-right px-4 py-2">Start</th>
                                        <th class="text-right px-4 py-2">Finish</th>
                                        <th class="text-right px-4 py-2">Miles</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                                    @forelse($mileageLog->entries as $entry)
                                        <tr>
                                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($entry['date'])->format('D, M j') }}</td>
                                            <td class="px-4 py-3">{{ $entry['time'] }}</td>
                                            <td class="px-4 py-3">{{ $entry['description'] }}</td>
                                            <td class="px-4 py-3">{{ $entry['location'] }}</td>
                                            <td class="px-4 py-3 text-right">{{ $entry['start'] }}</td>
                                            <td class="px-4 py-3 text-right">{{ $entry['finish'] }}</td>
                                            <td class="px-4 py-3 text-right font-medium">{{ $entry['miles'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                                No entries found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
