<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Evento;
use App\Models\Pessoa;
use App\Models\EventoPessoa;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $agora = Carbon::now('America/Sao_Paulo'); // Corrige o mês e o dia real

        $ano = $request->input('ano', $agora->year);
        $mes = $request->input('mes', $agora->month);
        $pessoaId = $request->input('pessoa_id');

        $referencia = Carbon::createFromDate($ano, $mes, 1, 'America/Sao_Paulo');
        $inicioMes = $referencia->copy()->startOfMonth();
        $fimMes = $referencia->copy()->endOfMonth();

        $inicioCalendario = $inicioMes->copy()->startOfWeek(Carbon::SUNDAY);
        $fimCalendario = $fimMes->copy()->endOfWeek(Carbon::SATURDAY);

        $diasDoMes = collect();
        $dia = $inicioCalendario->copy();
        while ($dia <= $fimCalendario) {
            $diasDoMes->push($dia->copy());
            $dia->addDay();
        }

        $eventos = collect();

        if ($pessoaId) {
            $eventoIds = EventoPessoa::where('pessoa_id', $pessoaId)->pluck('evento_id');

            $eventos = Evento::whereIn('id', $eventoIds)
                ->where(function ($query) use ($inicioCalendario, $fimCalendario) {
                    $query->whereBetween('data_ini', [$inicioCalendario, $fimCalendario])
                          ->orWhereBetween('data_fim', [$inicioCalendario, $fimCalendario]);
                })
                ->get();
        } else {
            $eventos = Evento::where(function ($query) use ($inicioCalendario, $fimCalendario) {
                $query->whereBetween('data_ini', [$inicioCalendario, $fimCalendario])
                      ->orWhereBetween('data_fim', [$inicioCalendario, $fimCalendario]);
            })->get();
        }

        $pessoas = Pessoa::all();
        $hoje = Carbon::now('America/Sao_Paulo'); // Para destacar o dia certo na view

        return view('agenda.index', compact('diasDoMes', 'eventos', 'referencia', 'hoje', 'pessoas', 'pessoaId'));
    }
}
