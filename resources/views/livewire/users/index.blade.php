<div>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h1>
    </x-slot>

    <div> {{-- Single root element wrapper required for Livewire --}}
        <x-breadcrumbs />

        {{-- Page Heading and Create Button --}}
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="xl">Users</flux:heading>
            <flux:button
    as="a"
    href="{{ route('users.create') }}"
    icon="plus"
    variant="primary">
    {{ __('Create User') }}
</flux:button>
        </div>

        <flux:separator variant="subtle" class="my-8" />
        <div class="h-8"></div>

        {{-- Flux Table --}}
        <flux:table>
            <flux:table.columns>
                <flux:table.column></flux:table.column>
                <flux:table.column>ID</flux:table.column>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column class="max-md:hidden">Mobile</flux:table.column>
                <flux:table.column class="max-md:hidden">Role</flux:table.column>
                <flux:table.column class="max-md:hidden">Vehicle</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach($users as $user)
                    <flux:table.row>
                        <flux:table.cell class="pr-2"><flux:checkbox /></flux:table.cell>
                        <flux:table.cell>#{{ $user->id }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex items-center gap-2">
                                <span><flux:link href="{{ route('users.show', $user) }}" variant="subtle">{{ $user->name }}</flux:link></span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>{{ $user->email }}</flux:table.cell>
                        <flux:table.cell class="max-md:hidden">{{ $user->mobile }}</flux:table.cell>
                        <flux:table.cell class="max-md:hidden">
                            <flux:badge :color="$user->role === 'admin' ? 'green' : 'blue'" size="sm" inset="top bottom">
                                {{ ucfirst($user->role) }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell class="max-md:hidden">
    {{ optional($user->vehicle)->registration_number ?? '—' }}
</flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown position="bottom" align="end" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="eye">
                                    <flux:link  href="{{ route('users.show', $user) }}" variant="subtle">View</flux:link>
                                    </flux:menu.item>
                                    <flux:menu.item icon="pencil">
                                    <flux:link  href="{{ route('users.edit', $user) }}" variant="subtle">Edit</flux:link>
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
