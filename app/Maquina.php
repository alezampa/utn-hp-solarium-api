<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maquina extends Model
{
    //
    use SoftDeletes;

    public function turnos(){

        return $this->hasManyThrough('App\Turno', 'App\Servicio', 'id_maquina', 'id_servicio');

    }

    public function servicios(){
        return $this->hasMany('App\Servicio', 'id_maquina');
    }
}
