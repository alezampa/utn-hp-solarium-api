<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    //

    use SoftDeletes;

    public function turnos(){

        return $this->hasMany('App\Turno', 'id_cliente');

    }


}
