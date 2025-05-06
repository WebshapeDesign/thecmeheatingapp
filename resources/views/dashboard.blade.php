<x-layouts.app :title="__('Dashboard')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:heading size="xl">Dashboard</flux:heading>
    </div>

    <flux:separator variant="subtle" class="my-8" />
    <div class="h-8"></div>

    <div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
    <flux:heading>Quick Links</flux:heading>
    <div class="h-5"></div>
        <flux:navlist>
            <flux:navlist.item :href="route('users.create')" wire:navigate>{{ __('Create User') }}</flux:navlist.item>
            <flux:navlist.item :href="route('vehicles.create')" wire:navigate>{{ __('Create Vehicle') }}</flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
       
    Dashboard Stuff

</div>


    
</x-layouts.app>
