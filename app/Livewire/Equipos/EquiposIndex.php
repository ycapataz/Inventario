<?php

namespace App\Livewire\Equipos;

use App\Models\Equipos;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;

class EquiposIndex extends Component
{
    use WithPagination;

    public function crearEquipo()
{
    try {
        $this->validate();

        Equipos::create([
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'serial' => $this->serial,
            'almacenamiento' => $this->almacenamiento,
            'ram' => $this->ram,
            'sistema_operativo' => $this->sistema_operativo,
            'estado_id' => 1,
        ]);

        $this->reset([
            'marca',
            'modelo',
            'serial',
            'almacenamiento',
            'ram',
            'sistema_operativo',
        ]);

        Flux::modal('crear-equipo')->close();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Equipo creado',
            'text' => 'El equipo se registró correctamente',
        ]);

        $this->dispatch('equipo-creado');

    } catch (\Illuminate\Validation\ValidationException $e) {

        // ❌ Error de validación (Livewire ya marca los inputs)
        $this->dispatch('swal', [
            'icon' => 'error',
            'title' => 'Datos inválidos',
            'text' => 'Revisa los campos marcados en rojo',
        ]);

        throw $e; // importante para que Livewire muestre errores

    } catch (\Throwable $e) {

        // ❌ Error inesperado
        logger()->error($e);

        $this->dispatch('swal', [
            'icon' => 'error',
            'title' => 'Error',
            'text' => 'Ocurrió un error al crear el equipo',
        ]);
    }
}

    public function render()
    {
        return view('livewire.equipos.index', [
        'equipos' => Equipos::with('estado')
            ->orderBy('id', 'desc')
            ->paginate(8),
        ]);
    }
}
