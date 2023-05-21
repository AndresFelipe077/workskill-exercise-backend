<?php

use App\Http\Controllers\AlquilerController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CasaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('users', UserController::class);
Route::post('users/register', [UserController::class, 'register']);
Route::post('users/login', [UserController::class, 'login']);

Route::resource('estados', EstadoController::class);

Route::resource('alquiler', AlquilerController::class);

Route::resource('categoria', CategoriaController::class);

Route::resource('chat', ChatController::class);

Route::resource('casas', CasaController::class);
Route::get('casas-disponibles', [CasaController::class, 'casasDisponibles']);
Route::get('casas-cabanas', [CasaController::class, 'casasCabanas']);
Route::get('casas-ecologicas', [CasaController::class, 'casasEcologicas']);
Route::get('casas-familiares', [CasaController::class, 'casasFamiliares']);
Route::get('casas-prefabricadas', [CasaController::class, 'casasPrefabricadas']);
Route::post('alquilar/{id}', [CasaController::class, 'alquiler']);


