<?php

namespace App\Livewire\Equipos;

use App\Models\Equipos;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

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

    

    public function render()
    {
        return view('livewire.equipos.index', [
            'equipos' => Equipos::query()
                ->with('estado')
                ->buscarEquipos($this->buscarEquipos)
                ->orderBy('id', 'desc')
                ->paginate(8),
        ]);
    }
}
