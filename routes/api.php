<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampagneController;
use App\Http\Controllers\PatienteController;
use App\Http\Controllers\BadienGoxController;
use App\Http\Controllers\SageFemmeController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\ConsultatonController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// authentification

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);


//  gestion des sage-femmes

Route::resource('sages-femmes', SageFemmeController::class);
Route::put('/sage-femmes/{id}/archive', [SageFemmeController::class, 'archive']);


// gestion des patientes

Route::resource('patientes', PatienteController::class);

// gestion des consultations

Route::resource('consultations', ConsultatonController::class);

// gestion des rendez-vous

Route::resource('rv', RendezVousController::class);

// gestion des badiène gox

Route::resource('badiene-gox', BadienGoxController::class);

// gestion des campagnes

Route::resource('campagnes', CampagneController::class);