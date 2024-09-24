<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnfantController;
use App\Http\Controllers\VisiteController;
use App\Http\Controllers\ConseilController;
use App\Http\Controllers\CampagneController;
use App\Http\Controllers\PatienteController;
use App\Http\Controllers\BadienGoxController;
use App\Http\Controllers\SageFemmeController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\ConsultatonController;
use App\Http\Controllers\VaccinationController;
use App\Http\Controllers\AccouchementController;
use App\Http\Controllers\StructureSanteController;

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

// gestion des conseils

Route::resource('conseils', ConseilController::class);

// gestion des visites
Route::resource('visites', VisiteController::class);

// gestion des vaccinations

Route::resource('vaccinations', VaccinationController::class);

// gestion des accouchements

Route::resource('accouchements', AccouchementController::class);

// gestion des enfants

Route::resource('enfants', EnfantController::class);

// structure de santé

Route::resource('structure', StructureSanteController::class);