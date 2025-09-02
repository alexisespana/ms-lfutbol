<?php

namespace App\Models\Categoria;

use App\Models\Equipos\Equipos;
use App\Models\grupos;
use Illuminate\Database\Eloquent\Model;

class Categoria_Equipo extends Model
{
    protected $table = 'categoria_equipo';
    protected $fillable = [
        'categoria_id',
        'equipo_id',
        'grupo_id',
    ];
    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'id', 'categoria_id');
    }

    public function equipos()
    {
        return $this->hasOne(Equipos::class,'id', 'equipo_id');
    }
    public function grupos()
    {
        return $this->hasOne(grupos::class, 'id', 'grupo_id');

    }
}
