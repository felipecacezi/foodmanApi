<?php

use App\Http\Controllers\MesasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/', [MesasController::class, 'create']);
Route::get('/', [MesasController::class, 'list']);
Route::put('/', [MesasController::class, 'update']);
Route::delete('/', [MesasController::class, 'delete']);
