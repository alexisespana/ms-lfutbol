<?php

namespace App\Models\Jornada;

use App\Models\Grupos\Grupos_Categorias;
use Illuminate\Database\Eloquent\Model;

class JornadaCategoria extends Model
{
    protected $table = 'jornada_categorias';
    protected $fillable = [
        'jornada_id',
        'categoria_id',
    ];
    public function jornada()
    {
        return $this->hasOne(Jornada::class, 'id', 'jornada_id');
    }
    public function categoria()
    {
        return $this->hasOne(Grupos_Categorias::class, 'id', 'categoria_id');
    }
}
