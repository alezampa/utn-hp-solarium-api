<?php

namespace App\Http\Controllers\API;

use App\Horario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $horarios = Horario::all();

        if (count($horarios) > 0) {

            $apertura = $horarios[0]->horario_apertura;
            $cierre = $horarios[0]->horario_cierre;

            foreach ($horarios as $horario) {
                $apertura = min($apertura, $horario->horario_apertura);
                $cierre = max($cierre, $horario->horario_cierre);
            }
        }

        return [
           'horarios' => $horarios,
           'hora_apertura' => $apertura,
           'hora_cierre' => $cierre
        ];
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
            'dia' => 'required|unique:horarios',
            'horario_apertura' => 'required|date_format:H:i',
            'horario_cierre' => 'required|date_format:H:i'
        ]);

        $horario = new Horario();

        $horario->dia = $request->input('dia');
        $horario->horario_apertura = $request->input('horario_apertura');
        $horario->horario_cierre = $request->input('horario_cierre');

        $horario->save();

        return $horario;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function show(Horario $horario)
    {
        return $horario;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'horario_apertura' => 'sometimes|required|date_format:H:i',
            'horario_cierre' => 'sometimes|required|date_format:H:i'
        ]);

        $apertura = $request->input('horario_apertura');
        $cierre = $request->input('horario_cierre');

        if ($apertura) {
            $horario->horario_apertura = $apertura;
        }
        if ($cierre) {
            $horario->horario_cierre = $cierre;
        }

        $horario->save();

        return $horario;
    }

    public function updateHorarios(Request $request){

        $request->validate([
            'horarios' => 'required|array',
            'horarios.*.dia' => 'required',
            'horarios.*.horario_apertura' => 'required|date_format:H:i',
            'horarios.*.horario_cierre' => 'required|date_format:H:i'
        ]);

        $horarios = $request->input('horarios');
        $dias = [];
        foreach($horarios as $newHorario){

            $horario = Horario::find($newHorario['dia']);
            if(!$horario){
                $horario = new Horario();
                $horario->dia = $newHorario['dia'];
            }
            $horario->horario_apertura = $newHorario['horario_apertura'];
            $horario->horario_cierre = $newHorario['horario_cierre'];
            $horario->save();
            $dias[] = $newHorario['dia'];
        }

        Horario::whereNotIn('dia', $dias)->delete();

        return $this->index();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Horario $horario)
    {
        return ['deleted'=> $horario->delete()];
    }
}
