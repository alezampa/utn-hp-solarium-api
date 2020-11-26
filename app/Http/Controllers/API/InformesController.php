<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\InformesMaquinas;
use App\InformesTurnos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformesController extends Controller
{
    //

    public function turnos(Request $request){

        $request->validate([
            'desde' => 'nullable|date',
            'hasta' => 'nullable|date',
            'servicios' => 'nullable|string',
        ]);

        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $servicios = $request->input('servicios');

        $query = InformesTurnos::groupBy('id_servicio')->select('id_servicio', DB::raw('SUM(cantidad) as total'));

        if(!empty($desde)){

            $query->whereDate('fecha', '>=', $desde);

        }
        if(!empty($hasta)){

            $query->whereDate('fecha', '<=', $hasta);

        }
        if(!empty($servicios)){
            $servicios = explode(',', $servicios);
            $query->whereIn('id_servicio', $servicios);

        }

        return $query->get();


    }

    public function maquinas(Request $request){

        $request->validate([
            'desde' => 'nullable|date',
            'hasta' => 'nullable|date',
            'maquinas' => 'nullable|string',
        ]);

        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $maquinas = $request->input('maquinas');

        $query = InformesMaquinas::groupBy('id_maquina')->select('id_maquina', DB::raw('SUM(cantidad) as total'));

        if(!empty($desde)){

            $query->whereDate('fecha', '>=', $desde);

        }
        if(!empty($hasta)){

            $query->whereDate('fecha', '<=', $hasta);

        }
        if(!empty($maquinas)){
            $maquinas = explode(',', $maquinas);
            $query->whereIn('id_maquina', $maquinas);

        }

        return $query->get();

    }
}
