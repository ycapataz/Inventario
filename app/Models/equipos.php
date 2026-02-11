<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    /** @use HasFactory<\Database\Factories\EquiposFactory> */
    use HasFactory;

    protected function almacenamiento(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value . ' GB'
        );
    }

    protected function ram(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value . ' GB'
        );
    }


    protected $fillable = [
        'marca',
        'modelo',
        'serial',
        'activo_fijo',
        'almacenamiento',
        'ram',
        'sistema_operativo',
        'estado_id',
        'ciudad_id',
    ];

    // 🔗 Un equipo pertenece a un estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    // 🔗 Un equipo pertenece a una ciudad
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    // 🔗 Un equipo puede estar asignado a varios usuarios
    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'equipo_id');
    }


    //Buscardor para equipos
    #[Scope]
    protected function scopeBuscarEquipos(Builder $query, $value){

        if (blank($value)) {
            return $query;
        }

        return $query->where(function ($q) use ($value) {
        $q->where('serial', 'like', "%{$value}%")
          ->orWhere('marca', 'like', "%{$value}%")
          ->orWhere('modelo', 'like', "%{$value}%")
          ->orWhereHas('estado', function ($e) use ($value) {
              $e->where('nombre', 'like', "%{$value}%");
          })
          ->orWhereHas('ciudad', function ($c) use ($value) {
              $c->where('nombre', 'like', "%{$value}%");
          });
        });
    }

}
