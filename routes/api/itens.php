<?php

use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/', [ItemController::class, 'create']);
Route::get('/', [ItemController::class, 'list']);
Route::put('/', [ItemController::class, 'update']);
Route::delete('/', [ItemController::class, 'delete']);
