<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Servicio;
use App\Turno;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Servicio::all();
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
            'nombre' => 'required|max:100',
            'descripcion' => 'required',
            'duracion' => 'required|integer',
            'id_maquina' => 'sometimes|nullable|integer|exists:maquinas,id',
            'id_personal' => 'sometimes|nullable|integer|exists:personal,id',
            'insumos' => 'sometimes|array',
            'insumos.*.id' => 'required|integer|exists:insumos,id',
            'insumos.*.cantidad' => 'required|integer',

        ]);

        $servicio = new Servicio();

        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->duracion = $request->input('duracion');
        $servicio->id_maquina = $request->input('id_maquina');
        $servicio->id_personal = $request->input('id_personal');

        $insumos = $request->input('insumos');

        $servicio->save();

        if ($insumos) {
            $forAttach = [];

            foreach ($insumos as $insumo) {
                $forAttach[$insumo['id']] = ['cantidad_insumo' => $insumo['cantidad']];
            }
            $servicio->insumos()->attach($forAttach);
        }

        return $servicio;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio)
    {
        return $servicio;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Servicio $servicio)
    {
        $request->validate([
            'nombre' => 'sometimes|required|max:100',
            'descripcion' => 'sometimes|required',
            'duracion' => 'sometimes|required|integer',
            'id_maquina' => 'sometimes|nullable|integer|exists:maquinas,id',
            'id_personal' => 'sometimes|nullable|integer|exists:personal,id',
            'insumos' => 'sometimes|array',
            'insumos.*.id' => 'required|integer|exists:insumos,id',
            'insumos.*.cantidad' => 'required|integer',

        ]);

        if ($request->has('nombre')) {
            $servicio->nombre = $request->input('nombre');
        }
        if ($request->has('descripcion')) {
            $servicio->descripcion = $request->input('descripcion');
        }
        if ($request->has('duracion')) {
            $servicio->duracion = $request->input('duracion');
        }

        $servicio->id_maquina = $request->input('id_maquina');
        $servicio->id_personal = $request->input('id_personal');

        $insumos = $request->input('insumos', []);

        $servicio->save();


        $forAttach = [];

        foreach ($insumos as $insumo) {
            $forAttach[$insumo['id']] = ['cantidad_insumo' => $insumo['cantidad']];
        }
        $servicio->insumos()->sync($forAttach);


        return $servicio;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicio $servicio)
    {
        $servicio->insumos()->detach();
        return ['deleted' => $servicio->delete()];
    }


    public function turnos(Servicio $servicio)
    {

        if ($servicio->id_maquina) {
            $turnos = Turno::join('servicios', 'turnos.id_servicio', '=', 'servicios.id')
                ->select('turnos.*', 'servicios.duracion')
                ->where('servicios.id_maquina', $servicio->id_maquina)
                ->get();
        } else {
            $turnos = $servicio->turnos;
        }

        return $turnos->load(['cliente' =>  function ($query) {

            $query->withTrashed();
        }, 'servicio' =>  function ($query) {

            $query->withTrashed();
        }]);
    }
}
