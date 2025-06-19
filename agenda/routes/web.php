<?php

use App\Http\Controllers\pessoasController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EventoPessoaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/agenda', [AgendaController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('agenda.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Rotas Filtro Pessoa
Route::get('/pessoas/search', [pessoasController::class, 'search'])
    ->name('pessoas/search')->middleware(['auth', 'verified']);

//Rotas Filtro Evento
Route::get('/eventos/search', [EventoController::class, 'search'])
    ->name('eventos/search')->middleware(['auth', 'verified']);

//Rotas Pessoas
Route::resource("/pessoas", pessoasController::class)
    ->names('pessoas')->middleware(['auth', 'verified']);

//Rotas Eventos
Route::resource('/eventos', EventoController::class)
    ->names('eventos')->middleware(['auth', 'verified']);

//Rotas Evento Pessoa
Route::resource('/evento_pessoas',EventoPessoaController::class)
    ->names('evento_pessoas')->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
