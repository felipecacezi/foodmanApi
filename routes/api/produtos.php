<?php

use App\Http\Controllers\ProdutosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/', [ProdutosController::class, 'create']);
Route::get('/', [ProdutosController::class, 'list']);
Route::put('/', [ProdutosController::class, 'update']);
Route::delete('/', [ProdutosController::class, 'delete']);
