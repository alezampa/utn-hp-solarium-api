<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turno extends Model
{
    //

    protected $with = ['servicio','cliente'];

    public function servicio(){
        return $this->belongsTo('App\Servicio', 'id_servicio');
    }

    public function cliente(){
        return $this->belongsTo('App\Cliente', 'id_cliente');
    }
}
