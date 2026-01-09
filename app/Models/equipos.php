<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    /** @use HasFactory<\Database\Factories\EquiposFactory> */
    use HasFactory;

    protected $fillable = [
        'marca',
        'modelo',
        'serial',
        'almacenamiento',
        'ram',
        'sistema_operativo',
        'estado_id',
    ];

    // 🔗 Un equipo pertenece a un estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    // 🔗 Un equipo puede estar asignado a varios usuarios
    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'equipo_id');
    }

}
