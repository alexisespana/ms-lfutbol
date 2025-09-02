<?php

namespace App\Models\Arbitro;

use Illuminate\Database\Eloquent\Model;

class Arbitro extends Model
{
    protected $table = 'arbitro';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'apellidos',
        
    ];

}
