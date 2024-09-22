<?php

namespace App\Models\Temporada;

use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    protected $table ='temporada';
    protected $fillable = [
        'nombre',
        'ano',
        'vigente',
    ];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
