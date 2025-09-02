<?php

namespace App\Models\Equipos;

use App\Models\Categoria\Categoria;
use App\Models\Jugadores\Jugadores;
use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    //
    protected $table = 'equipos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nombre',
        'abr',
        'descripcion',
        'escudo',
        'color',
        'color_text',
        
    ];
    public function jugadores(){
        return $this->belongsToMany(Jugadores::class,'jugadores_equipos','equipo_id','id');

        // return $this->hasMany(Jugadores::class, 'id','id');
    }
    public function categoria(){
        return $this->belongsToMany(Categoria::class,'categoria_equipo','equipo_id','categoria_id');

        // return $this->hasMany(Jugadores::class, 'id','id');
    }
}
