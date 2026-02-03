<div>
    <div>
        <div class="flex justify-end mb-4">
            <div class="w-72">
                <flux:input kbd="⌘K" icon="magnifying-glass" placeholder="Search..." />
            </div>
        </div>
        <div class="rounded-xl border border-outline dark:border-outline-dark bg-surface dark:bg-surface-dark">
            <div class="overflow-x-auto overflow-hidden rounded-xl">
                <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                    <thead
                        class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                        <tr>
                            <th scope="col" class="p-4">ID</th>
                            <th scope="col" class="p-4">Marca</th>
                            <th scope="col" class="p-4">Modelo</th>
                            <th scope="col" class="p-4">Serial</th>
                            <th scope="col" class="p-4">Almacenamiento</th>
                            <th scope="col" class="p-4">Ram</th>
                            <th scope="col" class="p-4">Sistema OP</th>
                            <th scope="col" class="p-4">Estado</th>
                            <th scope="col" class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline dark:divide-outline-dark">
                        @forelse ($equipos as $equipo)
                            <tr>
                                <td class="p-4">{{ $equipo->id }}</td>
                                <td class="p-4">{{ $equipo->marca}}</td>
                                <td class="p-4">{{ $equipo->modelo }}</td>
                                <td class="p-4">{{ $equipo->serial }}</td>
                                <td class="p-4">{{ $equipo->almacenamiento }}</td>
                                <td class="p-4">{{ $equipo->ram }}</td>
                                <td class="p-4">{{ $equipo->sistema_operativo }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $color = match ($equipo->estado_id) {
                                            1 => 'emerald',
                                            2 => 'amber',
                                            3 => 'rose',
                                            default => 'zinc',
                                        };
                                    @endphp
                                    
                                <flux:badge color="{{ $color }}">
                                    {{ $equipo->estado?->nombre ?? 'Sin estado' }}
                                </flux:badge>
                                </td>
                                <td class="p-4">
                                    <flux:modal.trigger name="ver-usuario">
                                        <flux:button variant="ghost" size="sm"
                                            wire:click="" icon="pencil-square" />
                                    </flux:modal.trigger>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="5" class="p-4 text-center"> No hay equipos </th>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            <div class="p-4">
                {{ $equipos->links() }}
            </div>
        </div>
    </div>
    <div class="flex justify-end mb-4">
        <div class="w-72 p-4">
            <flux:modal.trigger name="crear-equipo">
                <flux:button variant="primary" color="blue">
                    Agregar equipo
                </flux:button>
            </flux:modal.trigger>
        </div>
    </div>
    @livewire('equipos.modal-create')
</div>
