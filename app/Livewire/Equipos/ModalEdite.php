<?php

namespace App\Livewire\Equipos;

use Livewire\Component;
use App\Models\Equipos;
use App\Models\Estado;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class ModalEdite extends Component
{
    public $equipoId;

    public $marca;
    public $modelo;
    public $serial;
    public $almacenamiento;
    public $ram;
    public $sistema_operativo;

    public $estado_id;
    public $estado_original_id;

    public $estadosPermitidos = [];

    #[On('refresh-equipos')]
    public function refreshEquipos() {}

    #[On('abrir-modal')]
    public function abrirModal(int $id)
    {
        $equipo = Equipos::findOrFail($id);

        $this->equipoId = $equipo->id;
        $this->marca = $equipo->marca;
        $this->modelo = $equipo->modelo;
        $this->serial = $equipo->serial;
        $this->almacenamiento = $equipo->almacenamiento;
        $this->ram = $equipo->ram;
        $this->sistema_operativo = $equipo->sistema_operativo;

        $this->estado_id = $equipo->estado_id;
        $this->estado_original_id = $equipo->estado_id;

        // 🔹 Estado actual siempre visible
        $estadoActual = Estado::where('id', $equipo->estado_id)->get();

        // 🟢 SOLO si está disponible puede cambiar
        if ($equipo->estado_id === 1) {
            $this->estadosPermitidos = Estado::whereIn('id', [1, 3])->get();
        } else {
            $this->estadosPermitidos = $estadoActual;
        }
    }

    protected function rules()
    {
        return [
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'serial' => [
                'required',
                'string',
                'max:100',
                Rule::unique('equipos', 'serial')->ignore($this->equipoId),
            ],
            'almacenamiento' => 'required|string|max:50',
            'ram' => 'required|string|max:50',
            'sistema_operativo' => 'required|string|max:100',
            'estado_id' => 'required|exists:estados,id',
        ];
    }

    // 👉 Paso 1: pedir confirmación
    public function actualizarEquipo()
    {
        $this->validate();

        Flux::modal('editar-equipo')->close();

        $this->dispatch('swal-confirm', [
            'title' => '¿Confirmar actualización?',
            'text' => '¿Deseas guardar los cambios del equipo?',
            'icon' => 'warning',
            'confirmButtonText' => 'Sí, actualizar',
            'cancelButtonText' => 'Cancelar',
        ]);
    }

    // 👉 Paso 2: guardar realmente
    #[On('confirmar-actualizacion')]
    public function confirmarActualizacion()
    {
        try {
            $equipo = Equipos::findOrFail($this->equipoId);

            // 🔒 Regla de negocio
            if ($this->estado_original_id !== 1) {
                $this->estado_id = $this->estado_original_id;
            }

            $equipo->update([
                'marca' => $this->marca,
                'modelo' => $this->modelo,
                'serial' => $this->serial,
                'almacenamiento' => $this->almacenamiento,
                'ram' => $this->ram,
                'sistema_operativo' => $this->sistema_operativo,
                'estado_id' => $this->estado_id,
            ]);

            Flux::modal('editar-equipo')->close();
            $this->dispatch('refresh-equipos');

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Equipo actualizado',
                'text' => 'Los cambios se guardaron correctamente',
            ]);
        } catch (\Throwable $e) {

            Log::error('Error al actualizar equipo', [
                'equipo_id' => $this->equipoId,
                'error' => $e->getMessage(),
            ]);

            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Ocurrió un problema al actualizar el equipo.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.equipos.modal-edite');
    }
}