<?php

use App\Http\Controllers\CadastrarVeiculoController;
use App\Http\Controllers\UpdateVeiculoController;
use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\BuscarVeiculoPorIdController;
use App\Http\Controllers\BuscarTodosVeiculosDisponiveisController;
use App\Http\Controllers\BuscarTodosVeiculosVendidosController;

Route::prefix('v1')->group(function () {
    Route::post('/veiculos', CadastrarVeiculoController::class);
    Route::get('/veiculos/disponiveis', BuscarTodosVeiculosDisponiveisController::class);
    Route::get('/veiculos/vendidos', BuscarTodosVeiculosVendidosController::class);
    Route::get('/veiculos/{id}', BuscarVeiculoPorIdController::class);
    Route::put('/v1/veiculos/{id}', UpdateVeiculoController::class);
});

