<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResources([
    'clientes' => 'API\ClienteController',
    'usuarios' => 'API\UserController',
    'maquinas' => 'API\MaquinaController',
    'insumos' => 'API\InsumoController',
    'horarios' => 'API\HorarioController',
    'turnos' => 'API\TurnoController',
    'personal' => 'API\PersonalController',
    'servicios' => 'API\ServicioController',
    'feriados' => 'API\FeriadoController'
]);

Route::get('servicios/{servicio}/turnos', 'API\ServicioController@turnos');
Route::get('maquinas/{id}/turnos', 'API\MaquinaController@turnos');
Route::get('maquinas/{id}/servicios', 'API\MaquinaController@servicios');
Route::put('horarios', 'API\HorarioController@updateHorarios');
Route::get('clientes/{cliente}/turnos', 'API\ClienteController@turnos');

Route::get('informes/turnos', 'API\InformesController@turnos');
Route::get('informes/maquinas', 'API\InformesController@maquinas');

Route::get('me', function () {
    $user = Auth::user();
    $user->load('rol', 'personal');
    return [
        "user" => $user,
    ];
})->middleware('auth:api');


