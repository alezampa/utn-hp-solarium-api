<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    //
    protected $primaryKey = 'dia';

    public $timestamps = false;

    public function getHorarioAperturaAttribute($value){

        return date('H:i', strtotime($value));

    }

    public function getHorarioCierreAttribute($value){

        return date('H:i', strtotime($value));

    }
}
