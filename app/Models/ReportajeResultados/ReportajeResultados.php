<?php

namespace App\Models\ReportajeResultados;

use Illuminate\Database\Eloquent\Model;

class ReportajeResultados extends Model
{
    
    protected $table ='reportaje_resultados';
    protected $fillable = [
        'id_resultado',
        'titulo',
        'descripcion',
        'imagen_principal',
        'imagen1',
        'imagen2',
    ];
    public $timestamps = false;
    
}
