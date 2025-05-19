<?php

use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TachesController;
use App\Http\Controllers\UserController;
use App\Models\Projet;
use App\Models\Realisation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {return view('users.inscription');});
Route::get('/connexion', function () {return view('users.connexion');});
Route::get('/projet', function () {return view('projet');})->middleware('role:admin');
Route::get('/utilisateurs', [UserController::class,'view_gestionnaires'])->middleware('role:admin');
Route::get('/mesTaches', [TachesController::class,'mesTaches'])->middleware('role:developpeur,analyste');
Route::get('/realisations',[TachesController::class,'view_realisations'])->middleware('role:admin');
Route::get('/taches',[TachesController::class,'AllTaches'])->middleware('role:admin');
Route::get('/view_details/{id}',[TachesController::class,'afficher_details'])->middleware('role:admin');
Route::get('/profil',[UserController::class,'view_profil'])->middleware('role:admin,developpeur,analyste');
Route::get('/view_profil/{id}',[ProjetController::class,'view_profil'])->middleware('role:admin,developpeur,analyste');

Route::post('/add_inscription', [UserController::class,'add_inscription'])->middleware('role:admin');
Route::post('/add_projet',[ProjetController::class,'add_projet'])->middleware('role:admin');
Route::post('/add_connexion',[UserController::class,'add_connexion'])->middleware('role:admin,developpeur,analyste');
Route::post('/add_gestionnaires',[UserController::class,'add_gestionnaires'])->middleware('role:admin');
Route::delete('/delete_gestionnaires/{id}',[UserController::class,'delete_gestionnaires'])->middleware('role:admin');
Route::put('/gestionnaires_edit/{id}',[UserController::class,'edit_gestionnaires'])->middleware('role:admin');
Route::post('/add_taches',[TachesController::class,'taskAdded'])->middleware('role:admin');
Route::delete('/delete_taches/{id}',[TachesController::class,'delete_taches'])->middleware('role:admin');
Route::put('/edit_taches/{id}',[TachesController::class,'edit_taches'])->middleware('role:admin');
Route::post('/add_realisations',[TachesController::class,'add_realisations'])->middleware('role:admin');
Route::delete('/delete_realisations/{id}',[TachesController::class,'delete_realisations'])->middleware('role:admin');
Route::put('/valider_taches/{id}',[TachesController::class,'valider_taches'])->middleware('role:developpeur,analyste');
