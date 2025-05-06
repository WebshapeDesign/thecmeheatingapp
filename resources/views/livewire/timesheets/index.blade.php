<div>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Timesheets') }}
        </h1>
    </x-slot>

    <div>
        <x-breadcrumbs />

        {{-- Page Heading and Create Button --}}
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="xl">Timesheets</flux:heading>
            <flux:button
                as="a"
                href="{{ route('timesheets.create') }}"
                icon="plus"
                variant="primary">
                {{ __('Create Timesheet') }}
            </flux:button>
        </div>

        <flux:separator variant="subtle" class="my-8" />
        <div class="h-8"></div>

        {{-- Flux Table --}}
        <flux:table>
            <flux:table.columns>
                <flux:table.column></flux:table.column>
                <flux:table.column>ID</flux:table.column>
                <flux:table.column>Week Starting</flux:table.column>
                <flux:table.column>User</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column class="max-md:hidden">Created</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach($timesheets as $timesheet)
                    <flux:table.row>
                        <flux:table.cell class="pr-2"><flux:checkbox /></flux:table.cell>
                        <flux:table.cell>#{{ $timesheet->id }}</flux:table.cell>
                        <flux:table.cell>{{ \Carbon\Carbon::parse($timesheet->week_starting)->format('j M Y') }}</flux:table.cell>
                        <flux:table.cell>{{ $timesheet->user->name }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="$timesheet->status === 'submitted' ? 'green' : 'yellow'" size="sm" inset="top bottom">
                                {{ ucfirst($timesheet->status) }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell class="max-md:hidden">{{ $timesheet->created_at->format('d M Y') }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown position="bottom" align="end" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="eye">
                                        <flux:link href="{{ route('timesheets.show', $timesheet) }}" variant="subtle">View</flux:link>
                                    </flux:menu.item>
                                    @if ($timesheet->status === 'draft' || auth()->user()->isAdmin())
                                        <flux:menu.item icon="pencil">
                                            <flux:link href="{{ route('timesheets.edit', $timesheet) }}" variant="subtle">Edit</flux:link>
                                        </flux:menu.item>
                                    @endif
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>