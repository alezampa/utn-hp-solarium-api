<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Personal as PersonalModel;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PersonalModel::with(['horarios'])->get();
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
            'email' => 'required|email',
            'horarios' => 'required|array',
            'horarios.*.dia' => 'required|integer',
            'horarios.*.hora_entrada' => 'required|date_format:H:i',
            'horarios.*.hora_salida' => 'required|date_format:H:i',
        ]);

        $personal = new PersonalModel();
        $personal->nombre = $request->input('nombre');
        $personal->apellido = $request->input('apellido');
        $personal->domicilio = $request->input('domicilio');
        $personal->dni = $request->input('dni');
        $personal->fecha_nacimiento = $request->input('fecha_nacimiento');
        $personal->telefono = $request->input('telefono');
        $personal->email = $request->input('email');

        $personal->save();

        $personal->horarios()->createMany($request->input('horarios'));

        return $personal;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function show(PersonalModel $personal)
    {
        $personal->horarios;
        return $personal;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PersonalModel $personal)
    {
        $request->validate([
            'nombre' => 'sometimes|required|max:100',
            'apellido' => 'sometimes|required|max:100',
            'domicilio' => 'sometimes|required|max:255',
            'dni' => 'sometimes|required|max:12',
            'fecha_nacimiento' => 'sometimes|required|date',
            'telefono' => 'sometimes|required|max:50',
            'email' => 'sometimes|required|email',
            'horarios' => 'sometimes|required|array',
            'horarios.*.dia' => 'sometimes|required|integer',
            'horarios.*.hora_entrada' => 'sometimes|required|date_format:H:i',
            'horarios.*.hora_salida' => 'sometimes|required|date_format:H:i',
        ]);
        
        if ($request->has('nombre')) {
            $personal->nombre = $request->input('nombre');
        }
        if ($request->has('apellido')) {
            $personal->apellido = $request->input('apellido');
        }
        if ($request->has('domicilio')) {
            $personal->domicilio = $request->input('domicilio');
        }
        if ($request->has('dni')) {
            $personal->dni = $request->input('dni');
        }
        if ($request->has('fecha_nacimiento')) {
            $personal->fecha_nacimiento = $request->input('fecha_nacimiento');
        }
        if ($request->has('telefono')) {
            $personal->telefono = $request->input('telefono');
        }
        if ($request->has('email')) {
            $personal->email = $request->input('email');
        }

        $personal->save();

        if ($request->has('horarios')) {
            $horarios = $request->input('horarios');
            foreach($horarios as $horario){
                $find = array('dia' => $horario['dia']);
                $update = array('hora_entrada' => $horario['hora_entrada'], 'hora_salida' => $horario['hora_salida']);
                $personal->horarios()->updateOrCreate($find, $update);
            }
            
        }

        return $personal;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonalModel $personal)
    {
        $personal->horarios()->delete();
        return ['deleted'=> $personal->delete()];
    }
}
