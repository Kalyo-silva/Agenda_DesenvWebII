<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\evento;

class EventoController extends Controller
{

    public function index(){
        $listaEventos = [];

        foreach(evento::all() as $evento){
            array_push($listaEventos,$evento);
        }

        return $listaEventos;
    }

    public function show(int $id){
        $evento = evento::findOrFail($id);

        return $evento;
    }

    public function store(Request $request){
        $evento = new evento;
        $evento->userId = $request->input('userId');
        $evento->data = $request->input('data');
        $evento->titulo = $request->input('titulo');
        $evento->descricao = $request->input('descricao');
        $evento->save();

        return $evento;
    }

    public function update(Request $request, int $id){
        $evento = evento::findOrFail($id);
        $evento->userId = $request->input('userId');
        $evento->data = $request->input('data');
        $evento->titulo = $request->input('titulo');
        $evento->descricao = $request->input('descricao');

        $evento->save();

        return $evento;
    }

    public function destroy(int $id){
        $evento = evento::findOrFail($id);

        $evento->delete();

        return 'Removido com sucesso!';
    }
}
