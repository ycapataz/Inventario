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
                        wire:model.defer="serial"
                        :error="$errors->first('serial')"
                    />

                    <flux:input
                        label="Almacenamiento (GB)"
                        wire:model.defer="almacenamiento"
                        :error="$errors->first('almacenamiento')"
                    />

                    <flux:input
                        label="RAM (GB)"
                        wire:model.defer="ram"
                        :error="$errors->first('ram')"
                    />

                    <flux:input
                        label="Sistema Operativo"
                        wire:model.defer="sistema_operativo"
                        :error="$errors->first('sistema_operativo')"
                    />

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