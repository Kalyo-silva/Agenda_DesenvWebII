<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\eventoResponsavel;

class EventoResponsavelController extends Controller
{

    public function index(){
        $ListaEventoResponsavel = [];

        foreach(eventoResponsavel::all() as $eventoResponsavel){
            array_push($ListaEventoResponsavel,$eventoResponsavel);
        }

        return $ListaEventoResponsavel;
    }
    
    public function show(int $id){
        $eventoResponsavel = eventoResponsavel::findOrFail($id);

        return $eventoResponsavel;
    }

    public function store(Request $request){
        $eventoResponsavel = new eventoResponsavel;
        $eventoResponsavel->userID = $request->input('userID');
        $eventoResponsavel->eventoID = $request->input('eventoID');
        $eventoResponsavel->save();

        return $eventoResponsavel;
    }

    public function update(Request $request, int $id){
        $eventoResponsavel = eventoResponsavel::findOrFail($id);
        $eventoResponsavel->userID = $request->input('userID');
        $eventoResponsavel->eventoID = $request->input('eventoID');
        $eventoResponsavel->save();

        return $eventoResponsavel;
    }

    public function destroy(int $id){
        $eventoResponsavel = eventoResponsavel::findOrFail($id);

        $eventoResponsavel->delete();

        return 'Removido com sucesso!';
    }
}
