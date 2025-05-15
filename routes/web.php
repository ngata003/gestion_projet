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

Route::get('/', function () {
    return view('users.inscription');
});
Route::get('/connexion', function () {
    return view('users.connexion');
});
Route::get('/projet', function () {
    return view('projet');
});
Route::get('/utilisateurs', [UserController::class,'view_gestionnaires']);
Route::get('/ajouter_realisation', function(){
    return view('realisations.realisation');
});
Route::post('/add_inscription', [UserController::class,'add_inscription']);
Route::get('/mesTaches', [TachesController::class,'mesTaches']);
Route::post('/add_projet',[ProjetController::class,'add_projet']);
Route::get('/realisations',[TachesController::class,'view_realisations']);
Route::post('/add_connexion',[UserController::class,'add_connexion']);
Route::post('/add_gestionnaires',[UserController::class,'add_gestionnaires']);
Route::delete('/delete_gestionnaires/{id}',[UserController::class,'delete_gestionnaires']);
Route::put('/gestionnaires_edit/{id}',[UserController::class,'edit_gestionnaires']);
Route::get('/taches',[TachesController::class,'AllTaches']);
Route:: post('/add_taches',[TachesController::class,'taskAdded']);
Route::delete('/delete_taches/{id}',[TachesController::class,'delete_taches']);
Route::put('/edit_taches/{id}',[TachesController::class,'edit_taches']);
Route::post('/add_realisations',[TachesController::class,'add_realisations']);
