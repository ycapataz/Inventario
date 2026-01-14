<?php

namespace App\Livewire\Inventario;

use App\Models\Usuarios;
use App\Models\Equipos;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $buscador = '';
    public $usuario_id = null;
    public $usuarioSeleccionado = null;
    public $equiposDisponibles = []; // ✅ NECESARIO
    public $equipo_id = null;        // ✅ equipo seleccionado
    public $modoEdicion = false;
    public $serialBuscado = '';
    protected $listeners = [
    'desasignarEquipo',
    ];

    //Filtro de tablas.
    #[Url(history:true)]
    public $sortBy = 'created_at';
    public $sortDirection = 'ASC';
    protected array $sortable = [
    'nombre'     => 'usuarios.nombre',
    'correo'     => 'usuarios.correo',
    'created_at' => 'usuarios.created_at',
    'serial'     => 'equipos.serial',
    'marca'      => 'equipos.marca',
    'modelo'     => 'equipos.modelo',
];


    public function setSortBy(string $field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'ASC';
        }

        $this->resetPage();
    }

    //Actualiza la paginacion para mejorar la vista
    public function updatedBuscador($property)
    {
        if ($property === 'buscador') {
            $this->resetPage();
        }
        
    }


    public function mount()
    {
    }

    public function accionEditarGuardar()
{
    // PRIMER CLICK → habilita edición
    if (!$this->modoEdicion) {
        $this->modoEdicion = true;
        return;
    }

    // SEGUNDO CLICK → guarda cambios
    if ($this->modoEdicion) {

        if (!$this->equipo_id || !$this->usuarioSeleccionado) {
            return;
        }

        // Liberar equipo anterior
        if ($this->usuarioSeleccionado->equipo_id) {
            Equipos::where('id', $this->usuarioSeleccionado->equipo_id)
                ->update(['estado_id' => 1]); // Disponible
        }

        // Asignar nuevo equipo
        $this->usuarioSeleccionado->update([
            'equipo_id' => $this->equipo_id,
        ]);

        // Marcar nuevo equipo como ocupado
        Equipos::where('id', $this->equipo_id)
            ->update(['estado_id' => 2]); // Ocupado

        // Refrescar datos
        $this->usuarioSeleccionado->refresh();

        // Reset UI
        $this->modoEdicion = false;
        $this->serialBuscado = '';
        $this->equipo_id = null;

        session()->flash('success', 'Equipo actualizado correctamente');
    }
}


public function desasignarEquipo()
{
    if (!$this->usuario_id) {
        return;
    }

    $usuario = Usuarios::find($this->usuario_id);

    if (!$usuario) {
        return;
    }

    if ($usuario->equipo_id) {
        Equipos::where('id', $usuario->equipo_id)
            ->update(['estado_id' => 1]);
    }

    Usuarios::where('id', $this->usuario_id)
        ->update(['equipo_id' => null]);

    $this->usuarioSeleccionado = $usuario->fresh();

    $this->dispatch('alert', [
        'type' => 'success',
        'title' => '¡Hecho!',
        'message' => 'El equipo fue desasignado correctamente'
    ]);
}




    // Ver / editar usuario
    public function verUsuario($id)
    {
        $this->usuario_id = $id;
        $this->usuarioSeleccionado = Usuarios::with('equipo')->findOrFail($id);

        $this->equipo_id = $this->usuarioSeleccionado->equipo_id;
        $this->serialBuscado = $this->usuarioSeleccionado->equipo->serial ?? '';

        $this->modoEdicion = false;

        // SOLO equipos disponibles (estado_id = 1)
        // EXCLUYE el equipo actual
        $this->equiposDisponibles = Equipos::where('estado_id', 1)
            ->where('id', '!=', $this->usuarioSeleccionado->equipo_id)
            ->get();
        }

    public function render()
    {
        $query = Usuarios::query()
            ->leftJoin('equipos', 'equipos.id', '=', 'usuarios.equipo_id')
            ->select('usuarios.*')
            ->with('equipo')
            ->search($this->buscador);

        if (isset($this->sortable[$this->sortBy])) {
            $query->orderBy(
                $this->sortable[$this->sortBy],
                $this->sortDirection
            );
        }

        return view('livewire.inventario.index', [
            'usuarios' => $query->paginate(15),
        ]);
    }
}