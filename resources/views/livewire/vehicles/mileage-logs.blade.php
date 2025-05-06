<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mileage Logs for Vehicle') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('vehicles.show', $vehicle) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Vehicle') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Mileage Logs: {{ $vehicle->registration_number }}</flux:heading>
        <flux:button as="a" href="{{ route('vehicles.show', $vehicle) }}" icon="arrow-left" variant="primary">
            {{ __('Back to Vehicle') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="my-8" />
    <div class="h-8"></div>
    
    <section class="w-full">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-12">
            <div class="md:col-span-1 flex flex-col items-start space-y-2">
            <flux:navlist>
    <flux:navlist.group heading="Options" class="mt-4">
        <flux:navlist.item :href="route('vehicles.index')" wire:navigate>
            {{ __('Back to Vehicles') }}
        </flux:navlist.item>
        <flux:navlist.item :href="route('vehicles.show', $vehicle)" :current="request()->routeIs('vehicles.show')" wire:navigate>
            {{ __('View ') . $vehicle->registration_number }}
        </flux:navlist.item>
        <flux:navlist.item :href="route('vehicles.edit', $vehicle)" :current="request()->routeIs('vehicles.edit')" wire:navigate>
            {{ __('Edit ') . $vehicle->registration_number }}
        </flux:navlist.item>
        <flux:navlist.item :href="route('vehicles.vanlogs', $vehicle)" :current="request()->routeIs('vehicles.vanlogs')" wire:navigate>
            {{ __('View Van Logs') }}
        </flux:navlist.item>
        <flux:navlist.item :href="route('vehicles.mileagelogs', $vehicle)" :current="request()->routeIs('vehicles.mileagelogs')" wire:navigate>
            {{ __('View Mileage Logs') }}
        </flux:navlist.item>
    </flux:navlist.group>
</flux:navlist>
            </div>

            <flux:separator class="md:hidden" />

            <div class="md:col-span-2">
                @if ($logs->count())
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>ID</flux:table.column>
                            <flux:table.column>Week Starting</flux:table.column>
                            <flux:table.column>Driver</flux:table.column>
                            <flux:table.column>Status</flux:table.column>
                            <flux:table.column>Actions</flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @foreach ($logs as $log)
                                <flux:table.row>
                                    <flux:table.cell>#{{ $log->id }}</flux:table.cell>
                                    <flux:table.cell>{{ \Carbon\Carbon::parse($log->week_starting)->format('j M Y') }}</flux:table.cell>
                                    <flux:table.cell>{{ optional($log->user)->name ?? '—' }}</flux:table.cell>
                                    <flux:table.cell>
                                        @if($log->submitted)
                                        <flux:badge color="blue" size="sm" inset="top bottom" class="mt-1">Submitted<</flux:badge>
                                        @else
                                        <flux:badge color="red" size="sm" inset="top bottom" class="mt-1">Draft</flux:badge>
                                        @endif
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:dropdown position="bottom" align="end" offset="-15">
                                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />
                                            <flux:menu>
                                                <flux:menu.item icon="eye">
                                                    <flux:link href="{{ route('mileagelogs.show', $log) }}" variant="subtle">View</flux:link>
                                                </flux:menu.item>
                                                @can('update', $log)
                                                    @if(!$log->submitted)
                                                        <flux:menu.item icon="pencil">
                                                            <flux:link href="{{ route('mileagelogs.edit', $log) }}" variant="subtle">Edit</flux:link>
                                                        </flux:menu.item>
                                                    @endif
                                                @endcan
                                            </flux:menu>
                                        </flux:dropdown>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                @else
                    <p class="text-gray-500 mt-6">No mileage logs found for this vehicle.</p>
                @endif
            </div>
        </div>
    </section>
</div>
