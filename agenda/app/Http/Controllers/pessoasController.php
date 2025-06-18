<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class PessoasController extends Controller
{
    public function index()
    {
        $listaPessoas = Pessoa::orderBy('nome', 'asc')->paginate(20);
        $pessoaSearch = null;
        return view('pessoas.index', compact('listaPessoas', 'pessoaSearch'));
    }

    public function create()
    {
        $usuarios = User::all();
        return view('pessoas.create', compact('usuarios'));
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
            'foto_perfil' => 'image|max:2048',
            'usuario_id' => 'nullable|exists:users,id'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $pessoa = new Pessoa();
            $pessoa->nome = $request->input('nome');
            $pessoa->data_nascimento = $request->input('data_nascimento');
            $pessoa->cpf = $request->input('cpf');
            $pessoa->telefone_contato = $request->input('telefone_contato');
            $pessoa->tipo_pessoa = $request->input('tipo_pessoa');
            $pessoa->usuario_id = $request->input('usuario_id');

            if ($foto = $request->file('foto_perfil')) {
                $filename = date('YmdHis') . $foto->getClientOriginalName();
                $foto->move(public_path('pfp'), $filename);
                $pessoa->foto_perfil = $filename;
            }

            if ($pessoa->save()) {
                return redirect()->route('pessoas.index')->with('success', 'Pessoa cadastrada com sucesso!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar a pessoa. Tente novamente.');
        }
    }

    public function edit(int $id)
    {
        try {
            $pessoa = Pessoa::findOrFail($id);
            $usuarios = User::all();
            return view('pessoas.edit', compact('pessoa', 'usuarios'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pessoas.index')->with('error', 'Pessoa não encontrada.');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|max:15',
            'telefone_contato' => 'required|string|max:15',
            'tipo_pessoa' => 'required|in:Profissional,Acolhido',
            'foto_perfil' => 'image|max:2048',
            'usuario_id' => 'nullable|exists:users,id'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pessoa = Pessoa::findOrFail($id);
        $pessoa->nome = $request->input('nome');
        $pessoa->data_nascimento = $request->input('data_nascimento');
        $pessoa->cpf = $request->input('cpf');
        $pessoa->telefone_contato = $request->input('telefone_contato');
        $pessoa->tipo_pessoa = $request->input('tipo_pessoa');
        $pessoa->usuario_id = $request->input('usuario_id');

        if ($foto = $request->file('foto_perfil')) {
            $filename = date('YmdHis') . $foto->getClientOriginalName();
            $foto->move(public_path('pfp'), $filename);
            $pessoa->foto_perfil = $filename;
        }

        if ($pessoa->save()) {
            return redirect()->route('pessoas.index')->with('success', 'Pessoa atualizada com sucesso!');
        }
    }

    public function destroy(int $id)
    {
        try {
            $pessoa = Pessoa::findOrFail($id);
            if ($pessoa->delete()) {
                if ($pessoa->foto_perfil && file_exists(public_path('pfp') . DIRECTORY_SEPARATOR . $pessoa->foto_perfil)) {
                    unlink(public_path('pfp') . DIRECTORY_SEPARATOR . $pessoa->foto_perfil);
                }
            }

            return redirect()->route('pessoas.index')->with('success', 'Pessoa excluída com sucesso!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pessoas.index')->with('error', 'Pessoa não encontrada.');
        } catch (\Exception $e) {
            return redirect()->route('pessoas.index')->with('error', 'Ocorreu um erro ao excluir a pessoa. Tente novamente.');
        }
    }

    public function search(Request $request)
    {
        $pessoaSearch = $request->input('pessoaSearch');

        $listaPessoas = Pessoa::where(DB::raw('LOWER(nome)'), 'like', '%' . strtolower($pessoaSearch) . '%')
            ->orWhere('cpf', 'like', '%' . strtolower($pessoaSearch) . '%')
            ->paginate(20);

        return view('pessoas.index', compact('listaPessoas', 'pessoaSearch'));
    }
}
