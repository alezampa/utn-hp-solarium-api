<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\InformesMaquinas;
use App\InformesTurnos;
use App\Turno;
use App\Servicio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return Turno::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_turno' => 'required|date',
            'id_cliente' => 'required|integer|exists:clientes,id',
            'id_servicio' => 'required|integer|exists:servicios,id',
        ]);

        $turno = new Turno();
        $turno->fecha_turno = Carbon::parse($request->input('fecha_turno'));
        $turno->id_cliente = $request->input('id_cliente');
        $turno->id_servicio = $request->input('id_servicio');

        $servicio = Servicio::find($turno->id_servicio);

        if ($servicio) {

            $turno->fecha_fin = Carbon::parse($request->input('fecha_turno'))->addMinutes($servicio->duracion);
        }

        $turno->save();

        $turno->refresh();
        $turno->load('servicio', 'cliente');

        return $turno;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function show(Turno $turno)
    {
        return $turno;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Turno $turno)
    {

        $request->validate([
            'turno_concretado' => 'required|boolean',
        ]);

        $turno->turno_concretado = $request->input('turno_concretado');
        $turno->save();

        $fecha = Carbon::create($turno->fecha_turno);

        $informeTurnos = InformesTurnos::where('fecha', $fecha->toDateString())
            ->where('id_servicio', $turno->id_servicio)
            ->first();

        if ($informeTurnos) {

            $informeTurnos->cantidad = $informeTurnos->cantidad + 1;
        } else {
            $informeTurnos = new InformesTurnos();
            $informeTurnos->fecha = $fecha->toDateString();
            $informeTurnos->id_servicio = $turno->id_servicio;
            $informeTurnos->cantidad = 1;
        }

        $informeTurnos->save();

        foreach($turno->servicio->insumos as $insumo){

            $insumo->stock = $insumo->stock - $insumo->pivot->cantidad_insumo;
            $insumo->save();

        }

        if ($turno->servicio->id_maquina) {

            $maquina = $turno->servicio->maquina;
            $maquina->cantidad_usos = $maquina->cantidad_usos + 1;
            $maquina->save();

            $informeMaquina = InformesMaquinas::where('fecha', $fecha->toDateString())
                ->where('id_maquina', $turno->servicio->id_maquina)
                ->first();

            if ($informeMaquina) {
                $informeMaquina->cantidad = $informeMaquina->cantidad + 1;
            } else {
                $informeMaquina = new InformesMaquinas();
                $informeMaquina->fecha = $fecha->toDateString();
                $informeMaquina->id_maquina = $turno->servicio->id_maquina;
                $informeMaquina->cantidad = 1;
            }
            $informeMaquina->save();
        }

        return $turno;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Turno $turno)
    {
        return ['deleted' => $turno->delete()];
    }
}
