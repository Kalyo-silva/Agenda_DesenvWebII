<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

abstract class Controller
{



    public function agenda()
    {
        $pessoaId = Auth::user()->id_pessoa;

        $eventos = DB::table('eventos')
            ->join('evento_pessoas', 'eventos.id', '=', 'evento_pessoas.evento_id')
            ->where('evento_pessoas.pessoa_id', $pessoaId)
            ->select('eventos.*')
            ->get();

        // Organizar eventos por dia e hora
        $eventosMapeados = [];
        foreach ($eventos as $evento) {
            $inicio = Carbon::parse($evento->data_ini);
            $diaSemana = $inicio->format('D'); // Ex: 'Mon', 'Tue'...

            $hora = $inicio->format('H');

            $eventosMapeados[$hora][$diaSemana][] = $evento;
        }

        return view('agenda', compact('eventosMapeados'));
    }
}
