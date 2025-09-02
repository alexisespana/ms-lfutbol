<?php

namespace App\Models\Jugadores;

use App\Models\Equipos\Equipos;
use Illuminate\Database\Eloquent\Model;

class Jugadores extends Model
{
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
    public function equipo()
    {
        return $this->belongsToMany(Equipos::class, 'jugadores_equipos', 'id', 'equipo_id');
    }
}
