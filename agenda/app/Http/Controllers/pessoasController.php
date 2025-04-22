<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pessoa;

class pessoasController extends Controller
{
    public function index(){
        $listaPessoas = [];

        foreach(Pessoa::all() as $pessoa){
            array_push($listaPessoas,$pessoa);
        }

        return view('pessoas.index', compact('listaPessoas'));
    }

    public function create(){
        return view('pessoas.create');
    }

    public function show(int $id){
        $pessoa = Pessoa::findOrFail($id);

        return $pessoa;
    }

    public function store(Request $request){
        $pessoa = new Pessoa;
        $pessoa->nome = $request->input('nome');
        $pessoa->data_nascimento = $request->input('data_nascimento');
        $pessoa->cpf = $request->input('cpf');
        $pessoa->telefone_contato = $request->input('telefone_contato'); 
        $pessoa->foto_perfil = $request->input('foto_perfil'); 

        $pessoa->save();

        return $pessoa;
    }

    public function update(Request $request, int $id){
        $pessoa = Pessoa::findOrFail($id);
        $pessoa->nome = $request->input('nome');
        $pessoa->data_nascimento = $request->input('data_nascimento');
        $pessoa->cpf = $request->input('cpf');
        $pessoa->telefone_contato = $request->input('telefone_contato'); 
        $pessoa->foto_perfil = $request->input('foto_perfil'); 

        $pessoa->save();

        return $pessoa;
    }

    public function destroy(int $id){
        $pessoa = Pessoa::findOrFail($id);

        $pessoa->delete();

        return 'Removido com sucesso!';
    }
}
