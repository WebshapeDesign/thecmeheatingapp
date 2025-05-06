<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Vehicle') }}
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
        <flux:heading size="xl">Edit Vehicle</flux:heading>
        <flux:button as="a" href="{{ route('vehicles.show', $vehicle) }}" icon="arrow-left" variant="primary">
            {{ __('View Vehicle') }}
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
                <form wire:submit.prevent="update" class="my-6 w-full space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <flux:input
                                wire:model="registration_number"
                                :label="__('Registration Number')"
                                :error="$errors->first('registration_number')"
                                required
                            />
                        </div>
                        <div>
                            <flux:input
                                wire:model="make"
                                :label="__('Make')"
                                :error="$errors->first('make')"
                                required
                            />
                        </div>
                        <div>
                            <flux:input
                                wire:model="model"
                                :label="__('Model')"
                                :error="$errors->first('model')"
                                required
                            />
                        </div>
                        <div>
                            <flux:select
                                wire:model="user_id"
                                :label="__('Assigned User')"
                                :error="$errors->first('user_id')"
                            >
                                <option value="">{{ __('None') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div>
    <flux:input
        wire:model="mileage"
        type="number"
        min="0"
        :label="__('Mileage')"
        :error="$errors->first('mileage')"
/>
</div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <flux:button type="submit" color="primary">
                            {{ __('Save Changes') }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
