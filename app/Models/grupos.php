<?php

namespace App\Models;

use App\Models\Equipos\Equipos;
use Illuminate\Database\Eloquent\Model;

class grupos extends Model
{
    protected $table = 'grupos';
    protected $columns = ['nombre'];
    public $timestamps = true;
    protected $primaryKey = 'id';


    public function equipos()
    {
        return $this->belongsToMany(Equipos::class, 'categoria_equipo', 'equipo_id', 'grupo_id');
    }
    

    

   
}


