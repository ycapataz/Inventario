<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Usuarios;
use App\Models\Equipos;

class UsuariosIndex extends Component
{
    use WithPagination;

    public $usuarioSeleccionado;
    public $equipo_id;
    public $equiposDisponibles = [];

    // 🔹 Abrir modal editar
    public function editar($id)
    {
        $this->usuarioSeleccionado = Usuarios::with('equipo')->findOrFail($id);

        $this->equipo_id = $this->usuarioSeleccionado->equipo_id;

        // Equipos disponibles + el que ya tiene asignado
        $this->equiposDisponibles = Equipos::where('estado_id', 1)
            ->orWhere('id', $this->equipo_id)
            ->get();
    }

    // 🔹 Guardar cambios
    public function guardar()
    {
        $this->validate([
            'equipo_id' => 'required|exists:equipos,id',
        ]);

        if ($this->equipo_id != $this->usuarioSeleccionado->equipo_id) {

            // Liberar equipo anterior
            Equipos::where('id', $this->usuarioSeleccionado->equipo_id)
                ->update(['estado_id' => 1]);

            // Asignar nuevo equipo
            $this->usuarioSeleccionado->update([
                'equipo_id' => $this->equipo_id,
            ]);

            // Marcar nuevo equipo como ocupado
            Equipos::where('id', $this->equipo_id)
                ->update(['estado_id' => 2]);
        }

        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.usuarios.index', [
            'usuarios' => Usuarios::with('equipo')->paginate(15),
        ]);
    }
}