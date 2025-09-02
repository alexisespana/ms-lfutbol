<?php

namespace App\Models\DetallesGoles;

use Illuminate\Database\Eloquent\Model;

class DetallesGoles extends Model
{
    protected $table = 'detalles_goles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_resultado',
        'goles_elocal',
        'min_elocal',
        'goles_evisit',
        'min_evisit',
    ];


}
