<div>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Holidays') }}
        </h1>
    </x-slot>

    <div>
        <x-breadcrumbs />

        {{-- Page Heading and Create Button --}}
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="xl">Holidays</flux:heading>
            @if(auth()->user()->holiday_days_remaining > 0)
                <flux:button
                    as="a"
                    href="{{ route('holidays.create') }}"
                    icon="plus"
                    variant="primary">
                    {{ __('Request Holiday') }}
                </flux:button>
            @endif
        </div>

        <flux:separator variant="subtle" class="my-8" />
        <div class="h-8"></div>

        {{-- Flux Table --}}
        <flux:table>
            <flux:table.columns>
                <flux:table.column></flux:table.column>
                <flux:table.column>ID</flux:table.column>
                <flux:table.column>Date Requested</flux:table.column>
                <flux:table.column>User</flux:table.column>
                <flux:table.column>Dates</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column class="max-md:hidden">Created</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach($holidays as $holiday)
                    <flux:table.row>
                        <flux:table.cell class="pr-2"><flux:checkbox /></flux:table.cell>
                        <flux:table.cell>#{{ $holiday->id }}</flux:table.cell>
                        <flux:table.cell>{{ \Carbon\Carbon::parse($holiday->date_requested)->format('d M Y') }}</flux:table.cell>
                        <flux:table.cell>{{ $holiday->user->name }}</flux:table.cell>
                        <flux:table.cell>
    {{ \Carbon\Carbon::parse($holiday->holiday_start_date)->format('d M Y') }}
    to
    {{ \Carbon\Carbon::parse($holiday->holiday_end_date)->format('d M Y') }}
</flux:table.cell>

                        <flux:table.cell>
                            <flux:badge
                                :color="match($holiday->status) {
                                    'approved' => 'green',
                                    'submitted' => 'yellow',
                                    'rejected' => 'red',
                                    default => 'gray'
                                }"
                                size="sm"
                                inset="top bottom"
                            >
                                {{ ucfirst($holiday->status) }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell class="max-md:hidden">{{ $holiday->created_at->format('d M Y') }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown position="bottom" align="end" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="eye">
                                        <flux:link href="{{ route('holidays.show', $holiday) }}" variant="subtle">View</flux:link>
                                    </flux:menu.item>
                                    @if ($holiday->status === 'draft' || auth()->user()->isAdmin())
                                        <flux:menu.item icon="pencil">
                                            <flux:link href="{{ route('holidays.edit', $holiday) }}" variant="subtle">Edit</flux:link>
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
