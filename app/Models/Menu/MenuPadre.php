<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPadre extends Model
{
    use HasFactory;
    protected $table = 'menu_padre';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nombre', 'icono', 'orden'];
    
    function Menu() {
        return $this->hasMany(Menu::class, 'id_menupadre','id')->orderBy('orden');
        
    }
}
