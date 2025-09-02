<?php

namespace App\Models\cod_tipo;

use Illuminate\Database\Eloquent\Model;

class cod_tipo extends Model
{
    protected $table = 'cod_tipo';
    public $timestamps = false;

    protected $fillable = [
        'cod_padre',
        'cod_tipo',
        'nombre',
        'status',
    ];
    
}
