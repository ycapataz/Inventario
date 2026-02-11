<?php

namespace App\Livewire\Equipos;

use App\Models\Equipos;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

class EquiposIndex extends Component
{
    use WithPagination;

    public $buscarEquipos = "";
    
    #[On('refresh-equipos')]
    public function refreshEquipos()
    {
    }

    //Actualiza la paginacion para el buscador
    public function updatingBuscarEquipos($property)
    {
        if ($property === 'buscarEquipos') {
            $this->resetPage();
        }
    }

    // ============================================================
    // CONFIGURACIÓN DE ORDENAMIENTO DE TABLA - HISTORIAL Y FILTROS
    // ============================================================
    #[Url(history:TRUE)]
    Public $sortBy = 'created_at';
    public $sortDirection = 'ASC';
    protected array $sortTable = [
        'id' => 'equipos.id',
        'marca' => 'equipos.marca',
        'modelo' => 'equipos.modelo',
        'serial' => 'equipos.serial',
        'activo_fijo' => 'equipos.activo_fijo',
        'almacenamiento' => 'equipos.almacenamiento',
        'ram' => 'equipos.ram',
        'sistema_operativo' => 'equipos.sistema_operativo',
        'created_at' => 'equipos.created_at',
        'estado_id' => 'equipos.estado_id',
        'ciudad_id' => 'equipos.ciudad_id',
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


    // ============================================================
    // FINAL DE LA CONFIGURACIÓN DE FILTROS Y ORDENAMIENTO
    // ============================================================

    

    public function render()
    {
        $query = Equipos::query()
            ->with(['estado', 'ciudad'])
            ->buscarEquipos($this->buscarEquipos);
        //CONFIGURACIÓN DE FILTROS Y ORDENAMIENTO
        if (isset($this->sortTable[$this->sortBy])) {
            $query->orderBy(
                $this->sortTable[$this->sortBy],
                $this->sortDirection
            );
        }
        //------------------------------------------

        return view('livewire.equipos.index', [
            'equipos' => $query->paginate(8),
        ]);
    }

}
