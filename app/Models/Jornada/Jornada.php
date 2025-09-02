<?php

namespace App\Models\Jornada;

use App\Models\Categoria\Categoria;
use App\Models\cod_tipo\cod_tipo;
use App\Models\EstadisticasJornada\EstadisticasJornada;
use App\Models\Juegos\juegos;
use App\Models\Temporada\Temporada;
use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    protected $table = 'jornada';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id_temporada',
        'id_categoria',
        'nombre',
        'fecha',
        'status',
    ];

    public function temporada(){
        return $this->belongsTo(Temporada::class, 'id_temporada', 'id');
    }
    public function status(){
        return $this->belongsTo(cod_tipo::class, 'status', 'id');
    }
    public function categoria(){
        return $this->hasOne(Categoria::class, 'id','id_categoria');
    }
    
    public function juegos(){
        return $this->hasMany(juegos::class, 'id_jornada','id');

    }
    
    public function EstadisticasJornada(){
        return $this->hasOne(EstadisticasJornada::class, 'jornada_id','id');
    }
}
