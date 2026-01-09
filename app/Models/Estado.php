<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    /** @use HasFactory<\Database\Factories\EstadoFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    // 🔗 Un estado tiene muchos equipos
    public function equipos()
    {
        return $this->hasMany(Equipos::class, 'estado_id');
    }
}
