<?php

namespace App\Livewire\Charts;

use Livewire\Component;
use App\Models\Equipos;

class EquiposChart extends Component
{
    public function getChartDataProperty()
    {
        return [
            
            'values' => [
                Equipos::where('estado_id', 1)->count(),
                Equipos::where('estado_id', 2)->count(),
                Equipos::where('estado_id', 3)->count(),
            ],
            'labels' => ['Disponibles', 'Asignados', 'Hurtados'],
        ];
    }

    public function render()
    {
        return view('livewire.charts.equipos-chart', [
            'chartData' => $this->chartData,
        ]);
    }
}