<div>
    <flux:modal name="editar-equipo">
        <div>
            <form wire:submit.prevent="actualizarEquipo" class="space-y-6">

                <h2 class="text-xl font-semibold">
                    Editar equipo
                </h2>

                {{-- GRID --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <flux:input
                        label="Marca"
                        wire:model.defer="marca"
                        :error="$errors->first('marca')"
                        disabled
                    />

                    <flux:input
                        label="Modelo"
                        wire:model.defer="modelo"
                        :error="$errors->first('modelo')"
                        disabled
                    />

                    <flux:input
                        label="Serial"
                        wire:model.defer="serial"
                        :error="$errors->first('serial')"
                        disabled
                    />

                    <flux:input
                        label="Almacenamiento"
                        wire:model.defer="almacenamiento"
                        :error="$errors->first('almacenamiento')"
                    />

                    <flux:input
                        label="RAM"
                        wire:model.defer="ram"
                        :error="$errors->first('ram')"
                    />

                    <flux:input
                        label="Sistema Operativo"
                        wire:model.defer="sistema_operativo"
                        :error="$errors->first('sistema_operativo')"
                    />
                    <flux:select
                        label="Estado"
                        wire:model.defer="estado_id"
                        :error="$errors->first('estado_id')"
                        :disabled="$estado_original_id !== 1"
                    >
                        @foreach ($estadosPermitidos as $estado)
                            <option value="{{ $estado->id }}">
                                {{ $estado->nombre }}
                            </option>
                        @endforeach
                    </flux:select>

                    @if ($estado_original_id !== 1)
                        <flux:text color="red">
                            Este equipo no puede cambiar de estado.
                        </flux:text>
                    @endif
                </div>

                {{-- FOOTER --}}
                <div class="flex justify-end gap-4 pt-6">
                    <flux:modal.close>
                        <flux:button variant="ghost">
                            Cancelar
                        </flux:button>
                    </flux:modal.close>

                    <flux:button
                        variant="primary"
                        color="blue"
                        type="submit"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Actualizar equipo</span>
                    </flux:button>
                </div>

            </form>
        </div>
    </flux:modal>
</div>
