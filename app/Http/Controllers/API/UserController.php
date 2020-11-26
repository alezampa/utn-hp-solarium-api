<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
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
            'usuario' => 'required|unique:usuarios',
            'password' => 'required',
            'id_rol' => 'sometimes|required|integer|exists:roles,id',
            'id_personal' => 'sometimes|integer|exists:personal,id'
        ]);

        $user = new User();
        $user->usuario = $request->input('usuario');
        $user->password = Hash::make($request->input('password'));
        $user->id_rol = $request->input('id_rol');
        $user->id_personal = $request->input('id_personal');
        $user->save();

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        return $usuario;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'id_rol' => 'sometimes|required|integer|exists:roles,id',
            'id_personal' => 'sometimes|nullable|integer|exists:personal,id'
        ]);

        if ($request->has('password')) {
            $pass = $request->input('password');
            if (!empty($pass)) {
                $usuario->password = Hash::make($pass);
            }
        }
        $usuario->usuario = $request->input('usuario');
        $usuario->id_rol = $request->input('id_rol');
        $usuario->id_personal = $request->input('id_personal');

        $usuario->save();

        return $usuario;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {
        return ['deleted' => $usuario->delete()];
    }
}
