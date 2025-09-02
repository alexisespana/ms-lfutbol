<?php

namespace App\Models\Jugadores;

use App\Models\Equipos\Equipos;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class Jugadores extends Model
{
    use Compoships;
    
    //
    protected $table = 'jugadores';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nombre',
        'apellidos',
        'cedula',
        'posicion',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'imagen'
      
    ];
    public function JugadoresEquipos()
    {
        // return $this->belongsToMany(Equipos::class, 'jugadores_equipos',['id', 'equipo_id'], ['localKey1', 'localKey2']);
        return $this->belongsToMany(Equipos::class, JugadoresEquipos::class, 'equipo_id', 'id');

    }
}
