<?php

use App\Http\Controllers\PedidosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/', [PedidosController::class, 'create']);
Route::get('/', [PedidosController::class, 'list']);
Route::put('/', [PedidosController::class, 'update']);
Route::delete('/', [PedidosController::class, 'delete']);
