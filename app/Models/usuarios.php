<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    /** @use HasFactory<\Database\Factories\UsuariosFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'correo',
        'dni',
        'equipo_id',
    ];
    // 🔗 Un usuario pertenece a un equipo
    public function equipo()
    {
        return $this->belongsTo(Equipos::class, 'equipo_id');
    }
}
