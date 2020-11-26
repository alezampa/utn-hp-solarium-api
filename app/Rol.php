<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    //

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = "roles";

    public function usuarios(){
        return $this->hasMany('App\User', 'id_rol');
    }
}
