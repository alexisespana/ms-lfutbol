<?php

namespace App\Models\Equipos;

use App\Models\Categoria\Categoria;
use App\Models\Jugadores\Jugadores;
use App\Models\Temporada\Temporada;
use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    //
    protected $table = 'equipos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'temporada_id',
        'nombre',
        'abr',
        'descripcion',
        'escudo',
        'color',
        'color_text',
        
    ];
    public function temporada(){
        return $this->hasOne(Temporada::class,'id','temporada_id');
    }
    public function jugadores(){
        return $this->belongsToMany(Jugadores::class,'jugadores_equipos','equipo_id','id');
    }
    public function categoria(){
        return $this->belongsToMany(Categoria::class,'categoria_equipo','equipo_id','categoria_id');
    }
   
}
