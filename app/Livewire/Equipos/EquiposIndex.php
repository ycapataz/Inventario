<?php

namespace App\Livewire\Equipos;

use App\Models\Equipos;
use Livewire\Component;
use Livewire\WithPagination;

class EquiposIndex  extends Component
{

    use WithPagination;

     public function mount()
    {
    }

    public function render()
    {
        return view('livewire.equipos.index', [
            'equipos'=> Equipos::with('estado')->paginate(15),
        ]);
    }
}
