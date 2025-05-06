<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Vehicle') }}
            </h2>
            <a href="{{ route('vehicles.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Vehicles') }}
            </a>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:heading size="xl">Create Vehicle</flux:heading>
    </div>

    <flux:separator variant="subtle" class="my-8" />

    <section class="w-full">
        <x-settings.layout :heading="__('Vehicle Information')" :subheading="__('Add a new vehicle to the system')">
            <form wire:submit="store" class="my-6 w-full space-y-6">
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
        :label="__('Starting Mileage')"
        :error="$errors->first('mileage')"
/>
</div>
                </div>

                <div class="flex justify-end mt-6">
                    <flux:button type="submit" color="primary">
                        {{ __('Create Vehicle') }}
                    </flux:button>
                </div>
            </form>
        </x-settings.layout>
    </section>
</div>
