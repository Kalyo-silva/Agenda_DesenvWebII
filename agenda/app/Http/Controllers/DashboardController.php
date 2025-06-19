<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Evento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Define fuso horário explicitamente
        $hoje = Carbon::now('America/Sao_Paulo')->startOfDay();

        $userId = Auth::id();
        $pessoa = \App\Models\Pessoa::where('usuario_id', $userId)->first();

        // Gera os 5 dias a partir de hoje
        $diasSemana = collect();
        for ($i = 0; $i < 5; $i++) {
            $diasSemana->push($hoje->copy()->addDays($i));
        }

        if (!$pessoa) {
            return view('dashboard', [
                'eventos' => collect(),
                'diasSemana' => $diasSemana,
                'mensagem' => 'Nenhuma pessoa está vinculada a este usuário.',
                'pessoaVinculada' => null,
            ]);
        }

        // Definir período do filtro corretamente
        $inicioPeriodo = $diasSemana->first()->copy()->startOfDay()->timezone('UTC');
        $fimPeriodo = $diasSemana->last()->copy()->endOfDay()->timezone('UTC');

        // Buscar eventos convertendo corretamente para UTC (caso o banco esteja nesse fuso)
        $eventos = Evento::whereBetween('data_ini', [$inicioPeriodo, $fimPeriodo])
            ->whereHas('pessoas', function ($query) use ($pessoa) {
                $query->where('pessoa_id', $pessoa->id);
            })
            ->get()
            ->map(function ($evento) {
                // Ajusta data para o timezone São Paulo para exibição correta
                $evento->data_ini = Carbon::parse($evento->data_ini)->timezone('America/Sao_Paulo');
                $evento->data_fim = $evento->data_fim ? Carbon::parse($evento->data_fim)->timezone('America/Sao_Paulo') : null;
                return $evento;
            });

        return view('dashboard', [
            'eventos' => $eventos,
            'diasSemana' => $diasSemana,
            'mensagem' => null,
            'pessoaVinculada' => $pessoa->nome,
        ]);
    }

    public function eventosDoUsuario()
    {
        $userId = Auth::id();
        $pessoa = \App\Models\Pessoa::where('usuario_id', $userId)->first();

        if (!$pessoa) {
            return 'Pessoa não encontrada para este usuário.';
        }

        $eventos = Evento::whereHas('pessoas', function ($query) use ($pessoa) {
            $query->where('pessoa_id', $pessoa->id);
        })->orderBy('data_ini')->get()->map(function ($evento) {
            $evento->data_ini = Carbon::parse($evento->data_ini)->timezone('America/Sao_Paulo');
            $evento->data_fim = $evento->data_fim ? Carbon::parse($evento->data_fim)->timezone('America/Sao_Paulo') : null;
            return $evento;
        });

        return view('teste-eventos', compact('eventos', 'pessoa'));
    }
}
