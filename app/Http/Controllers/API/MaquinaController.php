<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Maquina;
use Illuminate\Http\Request;

class MaquinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Maquina::all();
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
            'fecha_compra' => 'required|date',
        ]);

        $maquina = new Maquina();

        $maquina->nombre = $request->input('nombre');
        $maquina->descripcion = $request->input('descripcion');
        $maquina->fecha_compra = $request->input('fecha_compra');
        $maquina->cantidad_usos = $request->input('cantidad_usos');

        $maquina->save();

        return $maquina;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Maquina  $maquina
     * @return \Illuminate\Http\Response
     */
    public function show(Maquina $maquina)
    {
        return $maquina;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Maquina  $maquina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maquina $maquina)
    {
        $request->validate([
            'nombre' => 'sometimes|required|max:100',
            'descripcion' => 'sometimes|required',
            'fecha_compra' => 'sometimes|required|date',
        ]);

        if ($request->has('nombre')) {
            $maquina->nombre = $request->input('nombre');
        }
        if ($request->has('descripcion')) {
            $maquina->descripcion = $request->input('descripcion');
        }
        if ($request->has('fecha_compra')) {
            $maquina->fecha_compra = $request->input('fecha_compra');
        }
        if ($request->has('cantidad_usos')) {
            $maquina->cantidad_usos = $request->input('cantidad_usos');
        }

        $maquina->save();

        return $maquina;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Maquina  $maquina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maquina $maquina)
    {
        return ['deleted'=> $maquina->delete()];
    }

    public function turnos(Maquina $id){
        return $id->turnos;
    }

    public function servicios(Maquina $id){
        return $id->servicios;
    }
}
