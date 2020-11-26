<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{

    use SoftDeletes;

    protected $with = ['insumos', 'personal'];

    public function insumos(){
        return $this->belongsToMany('App\Insumo', 'servicios_insumos', 'id_servicio', 'id_insumo')->withPivot('cantidad_insumo');
    }

    public function turnos(){

        return $this->hasMany('App\Turno', 'id_servicio');

    }

    public function personal()
    {
        return $this->belongsTo('App\Personal', 'id_personal');
    }

    public function maquina()
    {
        return $this->belongsTo('App\Maquina', 'id_maquina');
    }

}
