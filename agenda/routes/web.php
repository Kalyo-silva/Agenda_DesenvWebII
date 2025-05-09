<?php

use App\Http\Controllers\pessoasController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EventoPessoaController;
use App\Http\Controllers\EventoResponsavelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Rotas Pessoas
Route::resource("/pessoas", pessoasController::class);

//Rotas Eventos
Route::resource('/eventos', EventoController::class);

//Rotas Evento Pessoa
Route::resource('/evento_pessoas',EventoPessoaController::class);

require __DIR__.'/auth.php';
