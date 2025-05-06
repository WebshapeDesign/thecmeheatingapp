<div>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vehicles') }}
        </h1>
    </x-slot>

    <div> {{-- Single root element wrapper required for Livewire --}}
        <x-breadcrumbs />

        {{-- Page Heading and Create Button --}}
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="xl">Vehicles</flux:heading>
            <flux:button
                as="a"
                href="{{ route('vehicles.create') }}"
                icon="plus"
                variant="primary">
                {{ __('Create Vehicle') }}
            </flux:button>
        </div>

        <flux:separator variant="subtle" class="my-8" />
        <div class="h-8"></div>

        {{-- Flux Table --}}
        <flux:table>
            <flux:table.columns>
                <flux:table.column></flux:table.column>
                <flux:table.column>ID</flux:table.column>
                <flux:table.column>Registration</flux:table.column>
                <flux:table.column>Mileage</flux:table.column>
                <flux:table.column>Make</flux:table.column>
                <flux:table.column>Model</flux:table.column>
                <flux:table.column class="max-md:hidden">Assigned User</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach($vehicles as $vehicle)
                    <flux:table.row>
                        <flux:table.cell class="pr-2"><flux:checkbox /></flux:table.cell>
                        <flux:table.cell>#{{ $vehicle->id }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex items-center gap-2">
                                <flux:link href="{{ route('vehicles.show', $vehicle) }}" variant="subtle">
                                    {{ $vehicle->registration_number }}
                                </flux:link>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>{{ number_format($vehicle->mileage ?? 0) }}</flux:table.cell>
                        <flux:table.cell>{{ $vehicle->make }}</flux:table.cell>
                        <flux:table.cell>{{ $vehicle->model }}</flux:table.cell>
                        <flux:table.cell class="max-md:hidden">
                            {{ optional($vehicle->user)->name ?? '—' }}
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown position="bottom" align="end" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />
                                <flux:menu>
                                    <flux:menu.item icon="eye">
                                        <flux:link href="{{ route('vehicles.show', $vehicle) }}" variant="subtle">View</flux:link>
                                    </flux:menu.item>
                                    <flux:menu.item icon="pencil">
                                        <flux:link href="{{ route('vehicles.edit', $vehicle) }}" variant="subtle">Edit</flux:link>
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
