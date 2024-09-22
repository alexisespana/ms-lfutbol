<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table ='roles';
    protected $fillable = [
        'role_id',
        'menu_id',
    ];
    public $timestamps = false;
}
