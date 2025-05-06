<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Timesheets for User') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Users') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Timesheets: {{ $user->name }}</flux:heading>
        <flux:button as="a" href="{{ route('users.index') }}" icon="arrow-left" variant="primary">
            {{ __('Back to Users') }}
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
                @if ($timesheets->count())
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>ID</flux:table.column>
                            <flux:table.column>Week Starting</flux:table.column>
                            <flux:table.column>Status</flux:table.column>
                            <flux:table.column>Actions</flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @foreach ($timesheets as $timesheet)
                                <flux:table.row>
                                    <flux:table.cell>#{{ $timesheet->id }}</flux:table.cell>
                                    <flux:table.cell>{{ \Carbon\Carbon::parse($timesheet->week_starting)->format('j M Y') }}</flux:table.cell>
                                    <flux:table.cell>
                                        <flux:badge :color="$timesheet->status === 'submitted' ? 'blue' : 'red'" size="sm" inset="top bottom">
                                            {{ ucfirst($timesheet->status) }}
                                        </flux:badge>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:dropdown position="bottom" align="end" offset="-15">
                                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />
                                            <flux:menu>
                                                <flux:menu.item icon="eye">
                                                    <flux:link href="{{ route('timesheets.show', $timesheet) }}" variant="subtle">View</flux:link>
                                                </flux:menu.item>
                                                @can('update', $timesheet)
                                                    <flux:menu.item icon="pencil">
                                                        <flux:link href="{{ route('timesheets.edit', $timesheet) }}" variant="subtle">Edit</flux:link>
                                                    </flux:menu.item>
                                                @endcan
                                            </flux:menu>
                                        </flux:dropdown>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                @else
                    <p class="text-gray-500 mt-6">No timesheets found for this user.</p>
                @endif
            </div>
        </div>
    </section>
</div>
