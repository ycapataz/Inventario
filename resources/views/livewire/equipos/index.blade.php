<div>
    <div>
        <div class="flex items-center justify-between mb-4">
            <div class="w-72">
                <flux:input wire:model.live.debounce.300ms="buscarEquipos" icon="magnifying-glass"
                    placeholder="Buscar..." />
            </div>

            <flux:modal.trigger name="crear-equipo">
                <flux:button variant="primary" color="blue">
                    Agregar equipo
                </flux:button>
            </flux:modal.trigger>
        </div>
        <div class="rounded-xl border border-outline dark:border-outline-dark bg-surface dark:bg-surface-dark">
            <div class="overflow-x-auto overflow-hidden rounded-xl">
                <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                    <thead
                        class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                        <tr>
                            <th scope="col" class="p-4" wire:click= "setSortBy('id')">
                                <x-ui.sort-button field="id" label="ID" :$sortBy :$sortDirection />
                            </th>
                            <th scope="col" class="p-4" wire:click= "setSortBy('marca')">
                                <x-ui.sort-button field="marca" label="Marca" :$sortBy :$sortDirection />
                            </th>
                            <th scope="col" class="p-4" wire:click= "setSortBy('modelo')">
                                <x-ui.sort-button field="modelo" label="Modelo" :$sortBy :$sortDirection />
                            </th>
                            <th scope="col" class="p-4" wire:click= "setSortBy('serial')">
                                <x-ui.sort-button field="serial" label="Serial" :$sortBy :$sortDirection />
                            </th>
                            <th scope="col" class="p-4" wire:click= "setSortBy('almacenamiento')">
                                <x-ui.sort-button field="almacenamiento" label="Almacenamiento" :$sortBy
                                    :$sortDirection />
                            </th>
                            <th scope="col" class="p-4" wire:click= "setSortBy('ram')">
                                <x-ui.sort-button field="ram" label="Ram" :$sortBy :$sortDirection />
                            </th>
                            <th scope="col" class="p-4" wire:click= "setSortBy('sistema_operativo')">
                                <x-ui.sort-button field="sistema_operativo" label="Sistema OP" :$sortBy
                                    :$sortDirection />
                            </th>
                            <th scope="col" class="p-4" wire:click= "setSortBy('estado_id')">
                                <x-ui.sort-button field="estado_id" label="Estado" :$sortBy :$sortDirection />
                            </th>
                            <th scope="col" class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline dark:divide-outline-dark">
                        @forelse ($equipos as $equipo)
                            <tr>
                                <td class="p-4">{{ $equipo->id }}</td>
                                <td class="p-4">{{ $equipo->marca }}</td>
                                <td class="p-4">{{ $equipo->modelo }}</td>
                                <td class="p-4">{{ $equipo->serial }}</td>
                                <td class="p-4">{{ $equipo->almacenamiento }}</td>
                                <td class="p-4">{{ $equipo->ram  }}</td>
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
                                    <flux:modal.trigger name="editar-equipo">
                                        <flux:button variant="ghost" size="sm" {{-- wire:click="abrirModal({{ $equipo->id }})" --}}
                                            wire:click="$dispatchTo('equipos.modal-edite','abrir-modal',{ id: {{ $equipo->id }} })"
                                            icon="pencil-square" />
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
        @livewire('equipos.modal-edite')
        @livewire('equipos.modal-create')
    </div>
