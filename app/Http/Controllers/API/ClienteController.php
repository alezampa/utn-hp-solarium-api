<?php

namespace App\Http\Controllers\API;

use App\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Cliente::query();
        if($request->has('s')){
            $s = "%" .$request->input('s'). "%";
            $query = $query->where('nombre', 'like', $s)
                ->orWhere('apellido', 'like', $s)
                ->orWhere('dni', 'like', $s);

        }

        return $query->get();

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
            'apellido' => 'required|max:100',
            'domicilio' => 'required|max:255',
            'dni' => 'required|max:12',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|max:50',
            'email' => 'required|email'
        ]);

        $cliente = new Cliente();
        $cliente->nombre = $request->input('nombre');
        $cliente->apellido = $request->input('apellido');
        $cliente->domicilio = $request->input('domicilio');
        $cliente->dni = $request->input('dni');
        $cliente->fecha_nacimiento = $request->input('fecha_nacimiento');
        $cliente->telefono = $request->input('telefono');
        $cliente->email = $request->input('email');

        $cliente->save();

        return $cliente;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
        return $cliente;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'sometimes|required|max:100',
            'apellido' => 'sometimes|required|max:100',
            'domicilio' => 'sometimes|required|max:255',
            'dni' => 'sometimes|required|max:12',
            'fecha_nacimiento' => 'sometimes|required|date',
            'telefono' => 'sometimes|required|max:50',
            'email' => 'sometimes|required|email'
        ]);

        if ($request->has('nombre')) {
            $cliente->nombre = $request->input('nombre');
        }
        if ($request->has('apellido')) {
            $cliente->apellido = $request->input('apellido');
        }
        if ($request->has('domicilio')) {
            $cliente->domicilio = $request->input('domicilio');
        }
        if ($request->has('dni')) {
            $cliente->dni = $request->input('dni');
        }
        if ($request->has('fecha_nacimiento')) {
            $cliente->fecha_nacimiento = $request->input('fecha_nacimiento');
        }
        if ($request->has('telefono')) {
            $cliente->telefono = $request->input('telefono');
        }
        if ($request->has('email')) {
            $cliente->email = $request->input('email');
        }

        $cliente->save();

        return $cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        return ['deleted'=> $cliente->delete()];
    }

    public function turnos(Cliente $cliente){

        return $cliente->turnos;

    }
}
