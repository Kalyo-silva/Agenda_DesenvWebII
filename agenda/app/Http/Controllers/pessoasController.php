<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PessoasController extends Controller
{
    public function index()
    {
        $listaPessoas = Pessoa::all();
        return view('pessoas.index', compact('listaPessoas'));
    }

    public function create()
    {
        return view('pessoas.create');
    }

    public function show(int $id)
    {
        $pessoa = Pessoa::findOrFail($id);
        return view('pessoas.show', compact('pessoa'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|max:15',
            'telefone_contato' => 'required|string|max:15',
            'tipo_pessoa' => 'required|in:Profissional,Acolhido',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();

            // Criando a pessoa com a foto (se enviada)
            Pessoa::create($data);

            return redirect()->route('pessoas.index')->with('success', 'Pessoa cadastrada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar a pessoa. Tente novamente.');
        }
    }

    public function edit(int $id)
    {
        try {
            $pessoa = Pessoa::findOrFail($id);
            return view('pessoas.edit', compact('pessoa'));
        } catch (ModelNotFoundException $e) {
            // Retorna mensagem de erro caso a pessoa não seja encontrada
            return redirect()->route('pessoas.index')->with('error', 'Pessoa não encontrada.');
        }
    }

    public function update(Request $request, $id)
    {
        $pessoa = Pessoa::findOrFail($id);

        $pessoa->update($request->only([
            'nome',
            'data_nascimento',
            'tipo_pessoa',
            'cpf',
            'telefone_contato',
            'foto_perfil'
        ]));

        return redirect()->route('pessoas.index')->with('success', 'Pessoa atualizada com sucesso!');
    }

    public function destroy(int $id)
    {
        try {
            $pessoa = Pessoa::findOrFail($id);
            $pessoa->delete();

            // Retorna a mensagem de sucesso
            return redirect()->route('pessoas.index')->with('success', 'Pessoa excluída com sucesso!');
        } catch (ModelNotFoundException $e) {
            // Retorna a mensagem de erro caso a pessoa não seja encontrada
            return redirect()->route('pessoas.index')->with('error', 'Pessoa não encontrada.');
        } catch (\Exception $e) {
            // Retorna a mensagem de erro caso ocorra algum outro erro
            return redirect()->route('pessoas.index')->with('error', 'Ocorreu um erro ao excluir a pessoa. Tente novamente.');
        }
    }
}
