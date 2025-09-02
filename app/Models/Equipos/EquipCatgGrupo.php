<?php

namespace App\Models\Equipos;

use App\Models\grupos;
use Illuminate\Database\Eloquent\Model;

class quipCatgGrupo extends Model
{
    protected $table = 'equip_catg_grupos';
    protected $fillable = [
        'idcat_equip',
        'grupo_id',
    ];
    public function grupos(){
        return $this->hasOne(grupos::class,'id','grupo_id');
    }
    public function categoria_equipo(){
        return $this->hasOne(EquipCatgGrupo::class,'id','idcat_equip');
    }
}
