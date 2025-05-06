<div>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Van Logs') }}
        </h1>
    </x-slot>

    <div> {{-- Single root element wrapper required for Livewire --}}
        <x-breadcrumbs />

        {{-- Page Heading and Create Button --}}
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="xl">Van Logs</flux:heading>
            <flux:button
                as="a"
                href="{{ route('vanlogs.create') }}"
                icon="plus"
                variant="primary">
                {{ __('Create Van Log') }}
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
                <flux:table.column>Vehicle</flux:table.column>
                <flux:table.column>Mileage</flux:table.column>
                @if (auth()->user()->isAdmin())
                    <flux:table.column class="max-md:hidden">Driver</flux:table.column>
                @endif
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach($vanlogs as $vanlog)
                    <flux:table.row>
                        <flux:table.cell class="pr-2"><flux:checkbox /></flux:table.cell>
                        <flux:table.cell>#{{ $vanlog->id }}</flux:table.cell>
                        <flux:table.cell>{{ \Carbon\Carbon::parse($vanlog->week_starting)->format('d M Y') }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:link href="{{ route('vanlogs.show', $vanlog) }}" variant="subtle">
                                {{ $vanlog->vehicle->registration_number ?? '—' }}
                            </flux:link>
                        </flux:table.cell>
                        <flux:table.cell>{{ number_format($vanlog->mileage ?? 0) }}</flux:table.cell>
                        @if (auth()->user()->isAdmin())
                            <flux:table.cell class="max-md:hidden">{{ $vanlog->user->name ?? '—' }}</flux:table.cell>
                        @endif
                        <flux:table.cell>
                            <flux:dropdown position="bottom" align="end" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />
                                <flux:menu>
                                    <flux:menu.item icon="eye">
                                        <flux:link href="{{ route('vanlogs.show', $vanlog) }}" variant="subtle">View</flux:link>
                                    </flux:menu.item>
                                    <flux:menu.item icon="pencil">
                                        <flux:link href="{{ route('vanlogs.edit', $vanlog) }}" variant="subtle">Edit</flux:link>
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>
