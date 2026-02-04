<div>
    <div class="flex justify-end mb-4">
        <div class="w-72">
            <flux:input
                wire:model.live.debounce.300ms="buscador"
                icon="magnifying-glass"
                placeholder="Buscar .."
            />
        </div>
    </div>
    <div class="rounded-xl border border-outline dark:border-outline-dark bg-surface dark:bg-surface-dark">
        <div class="overflow-x-auto overflow-hidden rounded-xl">
            <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                    <tr>
                        <th scope="col" class="p-4">Usuario</th>
                        <th scope="col" class="p-4">ID</th>
                        <th scope="col" class="p-4" wire:click= "setSortBy('marca')">
                                <x-ui.sort-button
                                field="marca"
                                label="Marca"
                                :$sortBy
                                :$sortDirection
                            />
                        </th>
                        <th scope="col" class="p-4" wire:click= "setSortBy('modelo')">
                            <x-ui.sort-button
                                field="modelo"
                                label="Modelo"
                                :$sortBy
                                :$sortDirection
                            />
                        </th>
                        <th scope="col" class="p-4" wire:click= "setSortBy('serial')">
                            <x-ui.sort-button
                                field="serial"
                                label="Serial"
                                :$sortBy
                                :$sortDirection
                            />
                        </th>
                        <th scope="col" class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline dark:divide-outline-dark">
                    @forelse ($usuarios as $usuario)

                        <tr>
                            <td class="p-4">
                                <div class="flex w-max items-center gap-2">
                                    <img class="size-10 rounded-full object-cover" src="https://img.freepik.com/free-icon/user_318-749758.jpg" alt="user avatar" />
                                    <div class="flex flex-col">
                                        <span class="text-neutral-900 dark:text-white">{{$usuario->nombre}}</span>
                                        <span class="text-sm text-neutral-600 opacity-85 dark:text-neutral-300">{{$usuario->correo}}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">{{ $usuario->equipo?->id ?? '—' }}</td>
                            <td class="p-4">{{ $usuario->equipo?->marca ?? 'Sin equipo' }}</td>
                            <td class="p-4">{{ $usuario->equipo?->modelo ?? 'Sin equipo' }}</td>
                            <td class="p-4">{{ $usuario->equipo?->serial ?? 'Sin equipo' }}</td>
                                <td class="p-4">
                                    <flux:modal.trigger name="ver-usuario">
                                        <flux:button
                                            variant="ghost"
                                            size="sm"
                                            wire:click="verUsuario({{ $usuario->id }})"
                                            icon="eye"
                                        />
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
            </div>
            <div class="p-4">
                {{ $usuarios->links() }}
            </div>
            @include('livewire.inventario.modal')
        </div>
    </div>
</div>





