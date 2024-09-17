<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatienteController;
use App\Http\Controllers\SageFemmeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
// Route::post('register', [AuthController::class, 'register']);


//  gestion des sage-femmes

Route::resource('sages-femmes', SageFemmeController::class);
Route::put('/sage-femmes/{id}/archive', [SageFemmeController::class, 'archive']);


// gestion des patientes

Route::resource('patientes', PatienteController::class);