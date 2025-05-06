<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Vehicle Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('vehicles.edit', $vehicle) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Edit Vehicle') }}
                </a>
                <a href="{{ route('vehicles.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Vehicles') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Vehicle Details: {{ $vehicle->registration_number }}</flux:heading>
        <flux:button as="a" href="{{ route('vehicles.edit', $vehicle) }}" icon="pencil" variant="primary">
            {{ __('Edit Vehicle') }}
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
                <div class="my-6 w-full space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Registration Number') }}</flux:text>
                            <flux:text class="mt-1">{{ $vehicle->registration_number }}</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Make') }}</flux:text>
                            <flux:text class="mt-1">{{ $vehicle->make }}</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Model') }}</flux:text>
                            <flux:text class="mt-1">{{ $vehicle->model }}</flux:text>
                        </div>
                        <div>
    <flux:text class="text-sm font-medium text-gray-700">{{ __('Mileage') }}</flux:text>
    <flux:text class="mt-1">{{ number_format($vehicle->mileage) ?? '—' }}</flux:text>
</div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Assigned User') }}</flux:text>
                            <flux:text class="mt-1">
                                {{ optional($vehicle->user)->name ?? '—' }}
                            </flux:text>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Created At') }}</flux:text>
                            <flux:text class="mt-1">{{ $vehicle->created_at->format('F j, Y g:i A') }}</flux:text>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ __('Last Updated') }}</flux:text>
                            <flux:text class="mt-1">{{ $vehicle->updated_at->format('F j, Y g:i A') }}</flux:text>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
