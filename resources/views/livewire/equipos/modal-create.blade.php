<div>
    {{-- MODAL --}}
    <flux:modal name="crear-equipo">

        <form wire:submit.prevent="crearEquipo" class="space-y-6">

            <h2 class="text-xl font-semibold">
                Crear equipo
            </h2>

            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <flux:input
                        label="Activo Fijo"
                        wire:model.live="activo_fijo"
                        :error="$errors->first('activo_fijo')"
                    />

                    <flux:input
                        label="Marca"
                        wire:model.defer="marca"
                        :error="$errors->first('marca')"
                    />

                    <flux:input
                        label="Modelo"
                        wire:model.defer="modelo"
                        :error="$errors->first('modelo')"
                    />

                    <flux:input
                        label="Serial"
                        wire:model.live="serial"
                        :error="$errors->first('serial')"
                    />
                    

                    <flux:input
                        label="Almacenamiento (GB)"
                        wire:model.live="almacenamiento"
                        :error="$errors->first('almacenamiento')"
                    />

                    <flux:input
                        label="RAM (GB)"
                        wire:model.live="ram"
                        :error="$errors->first('ram')"
                    />

                    <flux:select
                        label="Sistema Operativo"
                        wire:model.defer="sistema_operativo"
                        :error="$errors->first('sistema_operativo')"

                    >
                        <flux:select.option value="">-- Seleccione sistema operativo --</flux:select.option>
                        <flux:select.option value="Windows 10 Pro">Windows 10 Pro</flux:select.option>
                        <flux:select.option value="Windows 11 Pro">Windows 11 Pro</flux:select.option>
                        <flux:select.option value="macOS">macOS</flux:select.option>
                    </flux:select>

                    <flux:select
                        label="Ciudad"
                        wire:model.live="ciudad_id"
                        :error="$errors->first('ciudad_id')"                        
                    >
                        <flux:select.option value="">-- Seleccione ciudad --</flux:select.option>
                        @foreach($ciudades as $ciudad)
                            <flux:select.option value="{{ $ciudad->id }}">
                                {{ $ciudad->nombre }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>

            </div>

            {{-- FOOTER --}}
            <div class="flex justify-end gap-4 pt-6">
            <flux:modal.close>
                <flux:button variant="ghost">
                    Cancelar
                </flux:button>
            </flux:modal.close>
            <flux:button
                variant="primary" color="blue"
                type="submit"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Crear equipo</span>
            </flux:button>
            </div>
        </form>
    </flux:modal>
</div>