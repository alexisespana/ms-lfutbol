<?php

namespace App\Models\Sede;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = 'sede';
    protected $columns = ['nombre', 'direccion'];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
