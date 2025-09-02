<?php

namespace App\Models\Categoria;

use App\Models\Equipos\Equipos;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'alias',
        'vigente',
    ];
    public function equipos()
    {
        return $this->belongsToMany(Equipos::class, 'categoria_equipo', 'categoria_id', 'equipo_id');
    }
}
