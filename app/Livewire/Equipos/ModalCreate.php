<?php

namespace App\Livewire\Equipos;

use Livewire\Component;
use App\Models\Estado;
use Flux\Flux;
use App\Models\Equipos;

/**
 * Componente Livewire
 * -------------------
 * ModalCreate
 *
 * Este componente se encarga de:
 * - Mostrar un modal para crear un nuevo equipo
 * - Validar los datos ingresados
 * - Guardar el equipo en la base de datos
 * - Cerrar el modal y notificar a otros componentes
 */
class ModalCreate extends Component
{

    // =========================
    // PROPIEDADES DEL FORMULARIO
    // =========================
    public $marca;
    public $modelo;
    public $serial;
    public $almacenamiento;
    public $ram;
    public $sistema_operativo;

    // =========================
    // VALIDACIONES
    // =========================
    protected $rules = [
        'marca' => 'required|string|max:100',
        'modelo' => 'required|string|max:100',
        'serial' => 'required|string|max:100|unique:equipos,serial',
        'almacenamiento' => 'required|numeric|min:1',
        'ram' => 'required|numeric|min:1',
        'sistema_operativo' => 'required|string|max:100',
    ];

    // =========================
    // MÉTODO CREAR EQUIPO
    // =========================
    public function crearEquipo()
    {
        $this->validate();
        try {
            
            Equipos::create([
                'marca' => $this->marca,
                'modelo' => $this->modelo,
                'serial' => $this->serial,
                'almacenamiento' => $this->almacenamiento ,
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
            
            $this->dispatch('refresh-equipos');

        } catch (\Illuminate\Validation\ValidationException $e) {

            Flux::modal('crear-equipo')->close();
            // ❌ Error de validación (Livewire ya marca los inputs)
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Datos inválidos',
                'text' => 'Revisa los campos marcados en rojo',
            ]);

            throw $e; // importante para que Livewire muestre errores

        } catch (\Throwable $e) {

            Flux::modal('crear-equipo')->close();
            // ❌ Error inesperado
            logger()->error($e);

            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Ocurrió un error al crear el equipo',
            ]);
        }
    }

    /**
     * ============================
     * MÉTODO: render
     * ============================
     * - Retorna la vista del modal
     * - Envía los estados disponibles al formulario
     */
    public function render()
    {
        return view('livewire.equipos.modal-create', [
            'estados' => Estado::all(),
        ]);
    }
}