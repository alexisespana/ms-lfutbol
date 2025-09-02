<?php

namespace App\Models\Temporada;

use App\Models\Equipos\Equipos;
use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    protected $table = 'temporada';
    protected $fillable = [
        'nombre',
        'ano',
        'vigente',
    ];
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function equipos()
    {
        return $this->hasMany(Equipos::class, 'temporada_id', 'id');
    }
}
