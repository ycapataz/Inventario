<?php

namespace App\Livewire\Equipos;

use App\Models\Equipos;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;
use Livewire\Attributes\On;

class EquiposIndex extends Component
{
    use WithPagination;
    #[On('refresh-equipos')]
    public function refreshEquipos()
    {
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
