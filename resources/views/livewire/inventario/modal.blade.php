<div>
    <flux:modal name="ver-usuario" wire:ignore.self class="md:w-[900px]">
        @if ($usuarioSeleccionado)
            <div class="space-y-8">

                <!-- HEADER -->
                <div>
                    <flux:heading size="lg">Detalle del usuario</flux:heading>
                    <flux:text class="mt-1">
                        Información del usuario y del equipo asociado
                    </flux:text>
                </div>

                <!-- ===== USUARIO ===== -->
                <div class="space-y-4">
                    <flux:heading size="sm">Usuario</flux:heading>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <flux:input label="Nombre" :value="$usuarioSeleccionado->nombre" disabled />

                        <flux:input label="Correo" :value="$usuarioSeleccionado->correo" disabled />

                        <flux:input label="DNI" :value="$usuarioSeleccionado->dni" disabled />
                    </div>
                </div>


                <!-- ===== EQUIPO ===== -->
                <div class="space-y-4 p-3">
                    <flux:heading size="sm">Equipo asignado</flux:heading>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <flux:input label="Marca" :value="$usuarioSeleccionado->equipo->marca ?? ''" disabled />

                        <flux:input label="Modelo" :value="$usuarioSeleccionado->equipo->modelo ?? ''" disabled />

                        <!-- SERIAL INICIO -->

                        {{-- MODO LECTURA --}}
                        @if (!$modoEdicion)
                            <flux:input label="Serial" :value="$usuarioSeleccionado->equipo?->serial ?? ''" disabled />
                        @endif

                        {{-- MODO EDICIÓN --}}
                        @if ($modoEdicion)
                            <div class="relative">
                                <flux:input
                                    label="Serial"
                                    wire:model.live.debounce.300ms="serialBuscado"
                                    placeholder="Buscar serial disponible..."
                                    autocomplete="off"
                                />

                                @if (strlen($serialBuscado) > 0)
                                    <div
                                        class="absolute z-20 w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow max-h-48 overflow-auto mt-1"
                                    >
                                        @forelse (
                                            $equiposDisponibles->filter(fn ($e) =>
                                                str_contains(
                                                    strtolower($e->serial),
                                                    strtolower($serialBuscado)
                                                )
                                            ) as $equipo
                                        )
                                            <div
                                                class="px-3 py-2 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800"
                                                wire:click="
                                                    $set('equipo_id', {{ $equipo->id }});
                                                    $set('serialBuscado', '{{ $equipo->serial }}');
                                                    
                                                "
                                            >
                                                <div class="font-medium">{{ $equipo->serial }}</div>
                                                <div class="text-xs text-zinc-500">{{ $equipo->marca }}</div>
                                            </div>
                                        @empty
                                            <div class="px-3 py-2 text-sm text-zinc-500">
                                                No hay coincidencias
                                            </div>
                                        @endforelse
                                    </div>
                                @endif
                            </div>
                        @endif
                        <!-- SERIAL FINAL -->
                        <flux:input label="RAM" :value="$usuarioSeleccionado->equipo->ram ?? ''" disabled />

                        <flux:input label="Sistema Operativo"
                            :value="$usuarioSeleccionado->equipo->sistema_operativo ?? ''" disabled />
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 pt-4">

                    <!-- Botón Desasignar equipo -->
                    <flux:button
                        variant="primary" color="red"
                        wire:click="$dispatch('confirm-desasignar')"
                    >
                        Desasignar equipo
                    </flux:button>

                    <!-- Botón Editar/Guardar -->
                    <flux:button
                        variant="primary" color="yellow"
                        wire:click="accionEditarGuardar"
                    >
                        {{ $modoEdicion ? 'Guardar' : 'Editar' }}
                    </flux:button>

                </div>

            </div>
        @endif
    </flux:modal>
    <script>
        document.addEventListener('confirm-desasignar', () => {

            // cerrar modal Flux
            Flux.modal('ver-usuario').close()

            setTimeout(() => {
                Swal.fire({
                    title: '¿Desasignar equipo?',
                    text: 'El usuario quedará sin equipo asignado',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, desasignar',
                    cancelButtonText: 'Cancelar',
                    allowOutsideClick: false
                }).then((result) => {

                    if (result.isConfirmed) {
                        Livewire.dispatch('desasignarEquipo')
                    } else {
                        Flux.modal('ver-usuario').open()
                    }

                })
            }, 200)
        })

        document.addEventListener('close-modal', event => {
            Flux.modal('ver-usuario').close()
        })

        document.addEventListener('alert', event => {
            const data = event.detail

            Swal.fire({
                icon: data.type ?? 'success',
                title: data.title ?? 'Correcto',
                text: data.message ?? '',
                timer: 2000,
                showConfirmButton: false
            })
        })
    </script>
</div>
