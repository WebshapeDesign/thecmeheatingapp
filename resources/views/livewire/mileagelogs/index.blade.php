<div>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mileage Logs') }}
        </h1>
    </x-slot>

    <div> {{-- Single root element wrapper required for Livewire --}}
        <x-breadcrumbs />

        {{-- Page Heading and Create Button --}}
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="xl">Mileage Logs</flux:heading>
            <flux:button
                as="a"
                href="{{ route('mileagelogs.create') }}"
                icon="plus"
                variant="primary">
                {{ __('Create Mileage Log') }}
            </flux:button>
        </div>

        <flux:separator variant="subtle" class="my-8" />
        <div class="h-8"></div>

        {{-- Flux Table --}}
        <flux:table>
            <flux:table.columns>
                <flux:table.column></flux:table.column>
                <flux:table.column>ID</flux:table.column>
                <flux:table.column>Week Starting</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Vehicle</flux:table.column>
                <flux:table.column>Driver</flux:table.column>
                <flux:table.column>Total Miles</flux:table.column>
                <flux:table.column class="max-md:hidden">Created</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach($mileageLogs as $log)
                    <flux:table.row>
                        <flux:table.cell class="pr-2"><flux:checkbox /></flux:table.cell>
                        <flux:table.cell>#{{ $log->id }}</flux:table.cell>
                        <flux:table.cell>{{ \Carbon\Carbon::parse($log->week_starting)->format('M j, Y') }}</flux:table.cell>
                        <flux:table.cell>
                        <flux:badge :color="$log->status === 'draft' ? 'red' : 'blue'" size="sm" inset="top bottom" class="mt-1">
                        {{ ucfirst($log->status) }}
                        </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $log->vehicle->registration_number ?? '—' }}</flux:table.cell>
                        <flux:table.cell>{{ $log->user->name ?? '—' }}</flux:table.cell>
                        <flux:table.cell>{{ $log->total_miles }} miles</flux:table.cell>
                        <flux:table.cell class="max-md:hidden">
                            {{ $log->created_at->format('M j, Y') }}
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown position="bottom" align="end" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />
                                <flux:menu>
                                    <flux:menu.item icon="eye">
                                        <flux:link href="{{ route('mileagelogs.show', $log) }}" variant="subtle">View</flux:link>
                                    </flux:menu.item>
                                    @can('update', $log)
                                        <flux:menu.item icon="pencil">
                                            <flux:link href="{{ route('mileagelogs.edit', $log) }}" variant="subtle">Edit</flux:link>
                                        </flux:menu.item>
                                    @endcan
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>
