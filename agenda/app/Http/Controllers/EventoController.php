<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    public function index()
    {
        $listaEventos = Evento::with('pessoas')->get();
        $eventoSearch = null;
        return view('eventos.index', compact('listaEventos', 'eventoSearch'));
    }

    public function create()
    {
        // Buscando pessoas com o tipo 'Profissional' e 'Acolhido'
        $profissionais = Pessoa::where('tipo_pessoa', 'Profissional')->get();
        $acolhidos = Pessoa::where('tipo_pessoa', 'Acolhido')->get();

        return view('eventos.create', compact('profissionais', 'acolhidos'));
    }

    public function show(int $id)
    {
        $evento = Evento::with('pessoas')->findOrFail($id);
        return view('eventos.show', compact('evento'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'data_ini' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:datahora',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'required|string|in:agendado,pendente,concluido',
            'profissionais' => 'array',
            'acolhidos' => 'array',
        ]);

        // Contando o número de profissionais e acolhidos selecionados
        $totalPessoas = count($request->input('profissionais', [])) + count($request->input('acolhidos', []));

        // Verificando se o número de pessoas é menor que 2
        if ($totalPessoas < 2) {
            return back()->withErrors(['error' => 'O evento deve ter pelo menos duas pessoas vinculadas.']);
        }

        DB::beginTransaction();

        try {
            // Verificando se o usuário está autenticado
            $userId = Auth::id();
            if (!$userId) {
                return back()->withErrors(['error' => 'Usuário não autenticado.']);
            }

            // Criando o evento e atribuindo o userId corretamente
            $evento = Evento::create([
                'user_id' => $userId, // Atribuindo corretamente o userId
                'data_ini' => $request->input('data_ini'),
                'data_fim' => $request->input('data_fim'),
                'titulo' => $request->input('titulo'),
                'descricao' => $request->input('descricao'),
                'status' => $request->input('status')
            ]);

            // Obtendo os IDs dos profissionais e acolhidos
            $pessoasProfissionais = $request->input('profissionais', []);
            $pessoasAcolhidos = $request->input('acolhidos', []);

            // Inicializando o array de IDs
            $pessoasIds = array_merge($pessoasProfissionais, $pessoasAcolhidos);;

            // Verificando se temos pelo menos 2 pessoas associadas
            if (count($pessoasIds) < 2) {
                return back()->withErrors(['error' => 'É necessário vincular pelo menos duas pessoas ao evento.']);
            }


            foreach ($pessoasProfissionais as $pessoaId) {
                $evento->pessoas()->attach($pessoaId, [
                    'tipo_pessoa' => 'Profissional'
                ]);
            }

            foreach ($pessoasAcolhidos as $pessoaId) {
                $evento->pessoas()->attach($pessoaId, [
                    'tipo_pessoa' => 'Acolhido'
                ]);
            }
            
            DB::commit();

            return redirect()->route('eventos.index')->with('success', 'Evento criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro ao criar o evento: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        // Carrega o evento com os profissionais e acolhidos
        $evento = Evento::with(['pessoas'])->findOrFail($id);

        $profissionais = $evento->pessoas->where('tipo_pessoa', 'Profissional');
        $acolhidos = $evento->pessoas->where('tipo_pessoa', 'Acolhido');

        // Carrega todos os profissionais e acolhidos disponíveis para o select
        $profissionaisIds = $evento->pessoas()->where('pessoas.tipo_pessoa', 'Profissional')->pluck('pessoas.id')->toArray();
        $acolhidosIds = $evento->pessoas()->where('pessoas.tipo_pessoa', 'Acolhido')->pluck('pessoas.id')->toArray();

        return view('eventos.edit', compact('evento', 'profissionais', 'acolhidos', 'profissionaisIds', 'acolhidosIds'));
    }



    public function update(Request $request, int $id)
    {
        $request->validate([
            'data_ini' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:datahora',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'required|string|in:agendado,pendente,concluido',
            'profissionais' => 'array',
            'acolhidos' => 'array',
        ]);

        DB::beginTransaction();

        try {
            $evento = Evento::findOrFail($id);

            // Atualizando os dados do evento
            $evento->update([
                'data_ini' => $request->input('data_ini'),
                'data_fim' => $request->input('data_fim'),
                'titulo' => $request->input('titulo'),
                'descricao' => $request->input('descricao'),
                'status' => $request->input('status'),
            ]);

            // Obtendo os IDs dos profissionais e acolhidos
            $pessoasProfissionais = $request->input('profissionais', []);
            $pessoasAcolhidos = $request->input('acolhidos', []);

            // Combinando os IDs em um único array
            $pessoasIds = array_merge($pessoasProfissionais, $pessoasAcolhidos);

            // Verificando se há pelo menos duas pessoas associadas
            if (count($pessoasIds) < 2) {
                return back()->withErrors(['error' => 'O evento deve ter pelo menos duas pessoas vinculadas.']);
            }

            // Atualizando as associações na tabela pivot
            $evento->pessoas()->sync($pessoasIds);

            DB::commit();

            return redirect()->route('eventos.index')->with('success', 'Evento atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro ao atualizar o evento: ' . $e->getMessage()]);
        }
    }


    public function destroy(int $id)
    {
        DB::beginTransaction();

        try {
            $evento = Evento::findOrFail($id);
            $evento->pessoas()->detach(); // Remover todas as associações

            $evento->delete();

            DB::commit();

            return redirect()->route('eventos.index')->with('success', 'Evento excluído com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro ao excluir o evento: ' . $e->getMessage()]);
        }
    }

    public function search(Request $request)
    {
        $eventoSearch = $request->input('eventoSearch');
        
        // Pesquisa os eventos na barra de Pesquisa
        $listaEventos = Evento::where('titulo', 'like', '%'. $request->input('eventoSearch') .'%')
            ->orWhere('descricao', 'like', '%'. $request->input('eventoSearch') .'%')
            ->get();
        
        // Retorna as views com resultados da Pesquisa
        return view('eventos.index', compact('listaEventos', 'eventoSearch'));
    }
}
