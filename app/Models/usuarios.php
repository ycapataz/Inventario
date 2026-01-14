<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public function scopeSearch(Builder $query, $value)
    {
        if (! $value) {
            return;
        }

        $query->where(function ($q) use ($value) {
            $q->where('nombre', 'like', "%{$value}%")
            ->orWhere('correo', 'like', "%{$value}%")
            ->orWhere('dni', 'like', "%{$value}%")
            ->orWhereHas('equipo', function ($eq) use ($value) {
                $eq->where('serial', 'like', "%{$value}%");
            });
        });
    }
}
