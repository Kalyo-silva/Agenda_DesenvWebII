<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\eventoPessoa;

class EventoPessoaController extends Controller
{

    public function index(){
        $ListaEventoPessoa = [];

        foreach(eventoPessoa::all() as $eventoPessoa){
            array_push($ListaEventoPessoa,$eventoPessoa);
        }

        return $ListaEventoPessoa;
    }
    
    public function show(int $id){
        $eventoPessoa = eventoPessoa::findOrFail($id);

        return $eventoPessoa;
    }

    public function store(Request $request){
        $eventoPessoa = new eventoPessoa;
        $eventoPessoa->pessoaID = $request->input('pessoaID');
        $eventoPessoa->eventoID = $request->input('eventoID');
        $eventoPessoa->save();

        return $eventoPessoa;
    }

    public function update(Request $request, int $id){
        $eventoPessoa = eventoPessoa::findOrFail($id);
        $eventoPessoa->pessoaID = $request->input('pessoaID');
        $eventoPessoa->eventoID = $request->input('eventoID');
        $eventoPessoa->save();

        return $eventoPessoa;
    }

    public function destroy(int $id){
        $eventoPessoa = eventoPessoa::findOrFail($id);

        $eventoPessoa->delete();

        return 'Removido com sucesso!';
    }
}
