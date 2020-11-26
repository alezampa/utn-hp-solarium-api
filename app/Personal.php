<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal extends Model
{
    //
    use SoftDeletes;

    protected $table = 'personal';

    protected $with = ['horarios'];

    public function horarios(){

        return $this->hasMany('App\HorarioPersonal', 'id_personal');

    }
}
