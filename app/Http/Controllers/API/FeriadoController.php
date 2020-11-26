<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Feriado;

class FeriadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Feriado::all();
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
            'nombre' => 'required',
            'fecha' => 'required|date_format:Y-m-d'
        ]);

        $feriado = new Feriado();

        $feriado->nombre = $request->input('nombre');
        $feriado->fecha = $request->input('fecha');

        $feriado->save();

        return $feriado;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Feriado $feriado)
    {
        return $feriado;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feriado $feriado)
    {
        $request->validate([
            'fecha' => 'required|date_format:Y-m-d',
            'nombre' => 'string',
        ]);

        $feriado->nombre = $request->input('nombre');
        $feriado->fecha = $request->input('fecha');

        $feriado->save();

        return $feriado;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feriado $feriado)
    {
        return ['deleted'=> $feriado->delete()];
    }
}
