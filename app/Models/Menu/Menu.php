<?php

namespace App\Models\Menu;

use App\Models\Roles\Roles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['tipo','nombre','href','id_menupadre','orden'];

    
    function Rol() {
        return $this->belongsToMany(Roles::class, 'role_menu', 'menu_id','role_id');

    }
    function MenuPadre() {
        return $this->hasOne(MenuPadre::class, 'id', 'id_menupadre')->orderBy('orden');

    }
    
}
