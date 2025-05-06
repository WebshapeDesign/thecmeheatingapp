<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('users.edit', $user) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Edit User') }}
                </a>
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Users') }}
                </a>
</div>

        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Details for {{ $user->name }}</flux:heading>
        <flux:button as="a" href="{{ route('users.edit', $user) }}" icon="pencil" variant="primary">
    {{ __('Edit User') }}
</flux:button>
    </div>

    <flux:separator variant="subtle" class="my-8" />
    <div class="h-8"></div>

    
        
    <section class="w-full">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-12">
            <div class="md:col-span-1 flex flex-col items-start space-y-2">
    
            <flux:navlist>
                    <flux:navlist.group heading="User Options" class="mt-4">
                    <flux:navlist.item :href="route('users.index')" wire:navigate>
                            {{ __('All Users') }}
                        </flux:navlist.item>    
                    <flux:navlist.item :href="route('users.show', $user)" :current="request()->routeIs('users.show')" wire:navigate>
                            {{ __('View User Details') }}
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('users.edit', $user)" :current="request()->routeIs('users.edit')" wire:navigate>
                            {{ __('Edit User Details') }}
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('users.timesheets', $user)" :current="request()->routeIs('users.timesheets')" wire:navigate>
                            {{ __('View User Timesheets') }}
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('users.holidays', $user)" :current="request()->routeIs('users.holidays')" wire:navigate>
                            {{ __('View User Holidays') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>
                
</div>
      
<flux:separator class="md:hidden" />

<div class="md:col-span-2">
                <div class="my-6 w-full space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Name') }}</flux:text>
                        <flux:text class="mt-1">{{ $user->name }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Email') }}</flux:text>
                        <flux:text class="mt-1">{{ $user->email }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Mobile') }}</flux:text>
                        <flux:text class="mt-1">{{ $user->mobile }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Role') }}</flux:text>
                        <flux:badge :color="$user->role === 'admin' ? 'green' : 'blue'" size="sm" inset="top bottom" class="mt-1">
                            {{ ucfirst($user->role) }}
                        </flux:badge>
                    </div>
                    <div>
    <flux:text class="text-sm font-medium text-gray-700">{{ __('Assigned Vehicle') }}</flux:text>
    <flux:text class="mt-1">
        {{ optional($user->vehicle)->registration_number ?? '—' }}
    </flux:text>
</div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Created At') }}</flux:text>
                        <flux:text class="mt-1">{{ $user->created_at->format('F j, Y g:i A') }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">{{ __('Last Updated') }}</flux:text>
                        <flux:text class="mt-1">{{ $user->updated_at->format('F j, Y g:i A') }}</flux:text>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</div>