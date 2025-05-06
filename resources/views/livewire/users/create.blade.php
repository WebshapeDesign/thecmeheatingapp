<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create User') }}
            </h2>
            <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Users') }}
            </a>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Create User</flux:heading>
    </div>

    <flux:separator variant="subtle" class="my-8" />
    <div class="h-8"></div>

    <section class="w-full">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-12">
    <div class="md:col-span-1 flex flex-col items-start space-y-2">
    </div> 
      
      <flux:separator class="md:hidden" />
      
      <div class="flex-1 self-stretch max-md:w-[300px]">
          
      <div class="md:col-span-2">

            <form wire:submit="store" class="my-6 w-full space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:input
                            wire:model="name"
                            :label="__('Name')"
                            :error="$errors->first('name')"
                            required
                        />
                    </div>
                    <div>
                        <flux:input
                            wire:model="email"
                            type="email"
                            autocomplete="off"
                            :label="__('Email')"
                            :error="$errors->first('email')"
                            required
                        />
                    </div>
                    <div>
                        <flux:input
                            wire:model="mobile"
                            type="tel"
                            autocomplete="off"
                            :label="__('Mobile')"
                            :error="$errors->first('mobile')"
                        />
                    </div>
                    <div>
                        <flux:input
                            wire:model="password"
                            type="password"
                            autocomplete="off"
                            :label="__('Password')"
                            :error="$errors->first('password')"
                            required
                        />
                    </div>
                    <div>
                        <flux:select
                            wire:model="role"   
                            :label="__('Role')"
                            :error="$errors->first('role')"
                            required
                        >
                            <option value="user">{{ __('User') }}</option>
                            <option value="admin">{{ __('Admin') }}</option>
                        </flux:select>
                    </div>
                    <div>
    <flux:select
        wire:model="vehicle_id"
        :label="__('Assigned Vehicle')"
        :error="$errors->first('vehicle_id')"
    >
        <option value="">{{ __('None') }}</option>
        @foreach ($vehicles as $vehicle)
            <option value="{{ $vehicle->id }}">{{ $vehicle->registration_number }}</option>
        @endforeach
    </flux:select>
</div>
                </div>

                <div class="flex justify-end mt-6">
                    <flux:button type="submit" color="primary">
                        {{ __('Create User') }}
                    </flux:button>
                </div>
            </form>
            </div>
        </div>
    </section>
</div>