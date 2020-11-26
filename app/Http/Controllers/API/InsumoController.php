<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Insumo;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Insumo::all();
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
            'stock' => 'required|integer',
            'stock_minimo' => 'required|integer'
        ]);

        $insumo = new Insumo();

        $insumo->nombre = $request->input('nombre');
        $insumo->descripcion = $request->input('descripcion');
        $insumo->stock = $request->input('stock');
        $insumo->stock_minimo = $request->input('stock_minimo');

        $insumo->save();

        return $insumo;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function show(Insumo $insumo)
    {
        return $insumo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insumo $insumo)
    {
        $request->validate([
            'nombre' => 'sometimes|required|max:100',
            'descripcion' => 'sometimes|required',
            'stock' => 'sometimes|required|integer',
            'stock_minimo' => 'sometimes|required|integer'
        ]);

        if ($request->has('nombre')) {
            $insumo->nombre = $request->input('nombre');
        }
        if ($request->has('descripcion')) {
            $insumo->descripcion = $request->input('descripcion');
        }
        if ($request->has('stock')) {
            $insumo->stock = $request->input('stock');
        }
        if ($request->has('stock_minimo')) {
            $insumo->stock_minimo = $request->input('stock_minimo');
        }

        $insumo->save();

        return $insumo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Insumo  $insumo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insumo $insumo)
    {
        return ['deleted'=> $insumo->delete()];
    }
}
