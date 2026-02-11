<?php

namespace App\Livewire\Equipos;

use App\Models\Ciudad;
use Livewire\Component;
use App\Models\Estado;
use Flux\Flux;
use App\Models\Equipos;
use Illuminate\Validation\Rule;

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
    public $activo_fijo;
    public $almacenamiento;
    public $ram;
    public $sistema_operativo;
    public $ciudad_id;

    // =========================
    // VALIDACIONES
    // =========================
    protected $rules = [
        'marca' => 'required|string|max:100',
        'modelo' => 'required|string|max:100',
        'serial' => 'required|string|max:100|unique:equipos,serial',
        'activo_fijo' => [
            'required',
            'string',
            'regex:/^VARI[1-4][0-9]{3,5}$/u',
            'unique:equipos,activo_fijo'
        ],
        'almacenamiento' => 'required|integer|min:120|max:4096',
        'ram' => 'required|integer|in:2,4,8,16,32,64,128',
        'sistema_operativo' => 'required|string|in:Windows 10 Pro,Windows 11 Pro,macOS',
        'ciudad_id' => 'required|exists:ciudades,id'
    ];

    protected $messages = [
        'activo_fijo.regex' => 'El activo fijo debe tener formato VARI + dígito inicial (1-4) + 3-5 números. Ejemplo: VARI1001, VARI21234, VARI312345',
        'activo_fijo.unique' => 'Este activo fijo ya está registrado',
        'activo_fijo.required' => 'El activo fijo es obligatorio',
        'serial.unique' => 'Este serial ya está registrado',
        'almacenamiento.min' => 'El almacenamiento mínimo es 120 GB',
        'almacenamiento.max' => 'El almacenamiento máximo es 4096 GB',
        'ram.in' => 'La RAM debe ser 2,4,8,16,32,64 o 128 GB',
        'sistema_operativo.required' => 'Debe seleccionar un sistema operativo',
        'sistema_operativo.in' => 'Seleccione Windows 10 Pro, Windows 11 Pro o macOS',
    ];

    public function updatedActivoFijo($value)
    {
        $this->activo_fijo = strtoupper($value);
    }

    /**
     * Validación en tiempo real para activo_fijo
     */
    public function updated($propertyName)
    {
        if ($propertyName === 'activo_fijo') {
            $this->validateOnly('activo_fijo');
        }
        if ($propertyName === 'serial') {
            $this->validateOnly('serial');
        }
        if ($propertyName === 'ram') {
            $this->validateOnly('ram');
        }
    }

    // =========================
    // MÉTODO CREAR EQUIPO
    // =========================
    public function crearEquipo()
    {
        // Asegurar mayúsculas antes de guardar
        $this->activo_fijo = strtoupper($this->activo_fijo);
        $this->validate();
        try {
            
            Equipos::create([
                'marca' => $this->marca,
                'modelo' => $this->modelo,
                'serial' => $this->serial,
                'activo_fijo' => $this->activo_fijo,
                'almacenamiento' => $this->almacenamiento ,
                'ram' => $this->ram,
                'sistema_operativo' => $this->sistema_operativo,
                'estado_id' => 1,
                'ciudad_id' => $this->ciudad_id,
            ]);

            $this->reset([
                'marca',
                'modelo',
                'serial',
                'almacenamiento',
                'ram',
                'sistema_operativo',
                'activo_fijo',
                 'ciudad_id',
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
            'ciudades' => Ciudad::all(),
        ]);
    }
}