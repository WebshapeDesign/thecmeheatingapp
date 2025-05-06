<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Van Log Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('vanlogs.edit', $vanlog) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Edit Van Log') }}
                </a>
                <a href="{{ route('vanlogs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Van Logs') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-breadcrumbs />

    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">{{ $vanlog->created_at->format('j F, Y') }} Van Log for {{ $vanlog->vehicle->registration_number ?? '—' }}</flux:heading>
        <flux:button as="a" href="{{ route('vanlogs.edit', $vanlog) }}" icon="pencil" variant="primary">
            {{ __('Edit Van Log') }}
        </flux:button>
    </div>

    <flux:separator variant="subtle" class="my-8" />
    <div class="h-8"></div>

    <section class="w-full">

    <div class="grid grid-cols-2 md:grid-cols-3 gap-12">
    <div class="md:col-span-1 flex flex-col items-start space-y-2">
    
<flux:button as="a" href="{{ route('vanlogs.index') }}" icon="arrow-left" variant="subtle" size="sm">
    {{ __('Back to Van Logs') }}
</flux:button>
</div>
      
          <div class="md:col-span-2">



        <flux:tab.group>
            <flux:tabs wire:model="tab">
                <flux:tab name="details">Details</flux:tab>
                <flux:tab name="checks">Vehicle Checks</flux:tab>
                <flux:tab name="equipment">Vehicle Equipment</flux:tab>
                <flux:tab name="safety">Safety Equipment</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="details">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">Vehicle Registration</flux:text>
                        <flux:text class="mt-1">{{ $vanlog->vehicle->registration_number ?? '—' }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">Driver Name</flux:text>
                        <flux:text class="mt-1">{{ $vanlog->user->name ?? '—' }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">Week Starting</flux:text>
                        <flux:text class="mt-1">{{ $vanlog->week_starting->format('F j, Y') }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">Mileage</flux:text>
                        <flux:text class="mt-1">{{ number_format($vanlog->mileage ?? 0) }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">Created At</flux:text>
                        <flux:text class="mt-1">{{ $vanlog->created_at->format('F j, Y g:i A') }}</flux:text>
                    </div>
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">Last Updated</flux:text>
                        <flux:text class="mt-1">{{ $vanlog->updated_at->format('F j, Y g:i A') }}</flux:text>
                    </div>
                </div>
            </flux:tab.panel>

            <flux:tab.panel name="checks">
                <div class="space-y-6 my-6">
                    @foreach ([
                        'oil' => 'Oil Level',
                        'water' => 'Water Level',
                        'tyres' => 'Tyre Pressure & Spare',
                        'wash' => 'Windscreen Wash'
                    ] as $key => $label)
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ $label }}</flux:text>
                            <div class="mt-1 flex items-center justify-between">
                                <flux:text>{{ $vanlog->{$key . '_action'} ?: '—' }}</flux:text>
                                <flux:badge :color="$vanlog->{$key . '_checked'} ? 'green' : 'gray'" size="sm">
                                    {{ $vanlog->{$key . '_checked'} ? 'Checked' : 'Not Checked' }}
                                </flux:badge>
                            </div>
                        </div>
                    @endforeach
                    <div>
                        <flux:text class="text-sm font-medium text-gray-700">Vehicle Defects</flux:text>
                        <flux:text class="mt-1">{{ $vanlog->vehicle_defects ?: '—' }}</flux:text>
                    </div>
                </div>
            </flux:tab.panel>

            <flux:tab.panel name="equipment">
                <div class="space-y-6 my-6">
                    @foreach ([
                        'ladder' => 'Ladder/Steps',
                        'vacuum' => 'Vacuum',
                        'tools' => 'Tools on Van',
                        'extinguisher' => 'Fire Extinguisher Expiry Date'
                    ] as $key => $label)
                        <div>
                            <flux:text class="text-sm font-medium text-gray-700">{{ $label }}</flux:text>
                            <div class="grid grid-cols-3 gap-4 mt-1">
                                <flux:badge :color="$vanlog->{$key . '_checked'} ? 'green' : 'gray'">Checked</flux:badge>
                                <flux:badge :color="$vanlog->{$key . '_signed'} ? 'green' : 'gray'">Signed</flux:badge>
                                <flux:text>{{ $vanlog->{$key . '_defects'} ?: '—' }}</flux:text>
                            </div>
                        </div>
                    @endforeach
                </div>
            </flux:tab.panel>

            <flux:tab.panel name="safety">
                <div class="overflow-x-auto my-6">
                    <table class="min-w-full border border-zinc-200 text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-4 py-2 text-left">Item</th>
                                <th class="px-4 py-2 text-center">Required</th>
                                <th class="px-4 py-2 text-center">Actual</th>
                                <th class="px-4 py-2 text-center">Checked</th>
                                <th class="px-4 py-2 text-center">Signed</th>
                                <th class="px-4 py-2 text-left">Defects</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                            @foreach ([
                                'first_aid' => 'First Aid',
                                'fire_extinguisher' => 'Fire Extinguisher',
                                'accident_book' => 'Accident Book',
                                'eye_wash' => 'Eye Wash',
                                'company_id' => 'Company ID',
                                'safety_boots' => 'Safety Boots',
                                'safety_goggles' => 'Safety Goggles',
                                'hi_viz' => 'Hi Vis Jacket',
                                'gloves' => 'Gloves',
                                'hard_hat' => 'Hard Hat',
                            ] as $key => $label)
                                <tr>
                                    <td class="px-4 py-2">{{ $label }}</td>
                                    <td class="px-4 py-2 text-center">1</td>
                                    <td class="px-4 py-2 text-center">{{ $vanlog->{$key . '_actual'} ?? 0 }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <flux:badge :color="$vanlog->{$key . '_checked'} ? 'green' : 'gray'">
                                            {{ $vanlog->{$key . '_checked'} ? 'Yes' : 'No' }}
                                        </flux:badge>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <flux:badge :color="$vanlog->{$key . '_signed'} ? 'green' : 'gray'">
                                            {{ $vanlog->{$key . '_signed'} ? 'Yes' : 'No' }}
                                        </flux:badge>
                                    </td>
                                    <td class="px-4 py-2">{{ $vanlog->{$key . '_defects'} ?: '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </flux:tab.panel>
        </flux:tab.group>
    </section>
</div>
</div>
</div>
