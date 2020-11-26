<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HorarioPersonal extends Model
{
    //
    protected $fillable = ['dia', 'hora_entrada', 'hora_salida'];

    protected $table = 'horarios_personal';

    public $timestamps = false;


    public function getHoraEntradaAttribute($value){

        return date('H:i', strtotime($value));

    }

    public function getHoraSalidaAttribute($value){

        return date('H:i', strtotime($value));

    }

}
